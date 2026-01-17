<?php

namespace App\Presentation\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Presentation\Http\Requests\StoreProjectRequest;
use App\Presentation\Http\Requests\UpdateProjectRequest;
use App\UseCases\Project\{
    ListProjects,
    GetProjectById,
    CreateProject,
    UpdateProject,
    DeleteProject,
    PublishProject,
    ArchiveProject
};
use App\Infrastructure\Storage\ImageStorageService;
use App\Core\Exceptions\{ProjectNotFoundException, InvalidProjectDataException};
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Controller Admin : Gestion des projets (CRUD)
 *
 * @package App\Presentation\Http\Controllers\Admin
 */
class ProjectAdminController extends Controller
{
    public function __construct(
        private readonly ListProjects $listProjects,
        private readonly GetProjectById $getProjectById,
        private readonly CreateProject $createProject,
        private readonly UpdateProject $updateProject,
        private readonly DeleteProject $deleteProject,
        private readonly PublishProject $publishProject,
        private readonly ArchiveProject $archiveProject,
        private readonly ImageStorageService $imageService
    ) {}

    /**
     * Liste de tous les projets (admin)
     *
     * Route : GET /admin/projects
     */
    public function index(): View
    {
        $projects = $this->listProjects->all();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Afficher le formulaire de création
     *
     * Route : GET /admin/projects/create
     */
    public function create(): View
    {
        return view('admin.projects.create');
    }

    /**
     * Enregistrer un nouveau projet
     *
     * Route : POST /admin/projects
     */
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Upload de l'image si présente
            if ($request->hasFile('image')) {
                $imagePath = $this->imageService->storeProjectImage(
                    $request->file('image')
                );
                $data['image'] = $imagePath;
            }

            // Créer le projet via le Use Case
            $project = $this->createProject->execute($data);

            // Définir l'image dans l'entité si uploadée
            if (isset($imagePath)) {
                $project->setImage($imagePath);
                $this->updateProject->execute($project->getId(), ['image' => $imagePath]);
            }

            return redirect()
                ->route('admin.projects.show', $project->getId())
                ->with('success', 'Projet créé avec succès !');

        } catch (InvalidProjectDataException $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Afficher les détails d'un projet
     *
     * Route : GET /admin/projects/{id}
     */
    public function show(int $id): View|RedirectResponse
    {
        try {
            $project = $this->getProjectById->execute($id);

            return view('admin.projects.show', compact('project'));

        } catch (ProjectNotFoundException $e) {
            return redirect()
                ->route('admin.projects.index')
                ->withErrors(['error' => 'Projet non trouvé.']);
        }
    }

    /**
     * Afficher le formulaire d'édition
     *
     * Route : GET /admin/projects/{id}/edit
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            $project = $this->getProjectById->execute($id);

            return view('admin.projects.edit', compact('project'));

        } catch (ProjectNotFoundException $e) {
            return redirect()
                ->route('admin.projects.index')
                ->withErrors(['error' => 'Projet non trouvé.']);
        }
    }

    /**
     * Mettre à jour un projet
     *
     * Route : PUT/PATCH /admin/projects/{id}
     */
    public function update(UpdateProjectRequest $request, int $id): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Upload nouvelle image si présente
            if ($request->hasFile('image')) {
                $project = $this->getProjectById->execute($id);

                $imagePath = $this->imageService->storeProjectImage(
                    $request->file('image'),
                    $project->getImage() // Supprimer l'ancienne
                );

                $data['image'] = $imagePath;
            }

            // Mettre à jour via le Use Case
            $this->updateProject->execute($id, $data);

            return redirect()
                ->route('admin.projects.show', $id)
                ->with('success', 'Projet mis à jour avec succès !');

        } catch (ProjectNotFoundException $e) {
            return redirect()
                ->route('admin.projects.index')
                ->withErrors(['error' => 'Projet non trouvé.']);

        } catch (InvalidProjectDataException $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Supprimer un projet
     *
     * Route : DELETE /admin/projects/{id}
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            // Récupérer le projet pour supprimer son image
            $project = $this->getProjectById->execute($id);

            // Supprimer l'image associée
            if ($project->getImage()) {
                $this->imageService->deleteImage($project->getImage());
            }

            // Supprimer le projet
            $this->deleteProject->execute($id);

            return redirect()
                ->route('admin.projects.index')
                ->with('success', 'Projet supprimé avec succès !');

        } catch (ProjectNotFoundException $e) {
            return redirect()
                ->route('admin.projects.index')
                ->withErrors(['error' => 'Projet non trouvé.']);
        }
    }

    /**
     * Publier un projet
     *
     * Route : POST /admin/projects/{id}/publish
     */
    public function publish(int $id): RedirectResponse
    {
        try {
            $this->publishProject->execute($id);

            return redirect()
                ->back()
                ->with('success', 'Projet publié avec succès !');

        } catch (ProjectNotFoundException $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Projet non trouvé.']);

        } catch (InvalidProjectDataException $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Archiver un projet
     *
     * Route : POST /admin/projects/{id}/archive
     */
    public function archive(int $id): RedirectResponse
    {
        try {
            $this->archiveProject->execute($id);

            return redirect()
                ->back()
                ->with('success', 'Projet archivé avec succès !');

        } catch (ProjectNotFoundException $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Projet non trouvé.']);
        }
    }
}
