<?php

namespace App\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\UseCases\Project\ListProjects;
use App\UseCases\Project\GetProjectBySlug;
use App\Core\Exceptions\ProjectNotFoundException;
use Illuminate\View\View;
use Illuminate\Http\Response;

/**
 * Controller : Pages projets (Frontend)
 *
 * @package App\Presentation\Http\Controllers
 */
class ProjectController extends Controller
{
    public function __construct(
        private readonly ListProjects $listProjects,
        private readonly GetProjectBySlug $getProjectBySlug
    ) {}

    /**
     * Afficher la liste de tous les projets
     *
     * Route : GET /projects
     *
     * @return View
     */
    public function index(): View
    {
        // Récupérer uniquement les projets publiés
        $projects = $this->listProjects->published();

        return view('projects.index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Afficher les détails d'un projet
     *
     * Route : GET /projects/{slug}
     *
     * @param string $slug
     * @return View|Response
     */
    public function show(string $slug): View|Response
    {
        try {
            // Récupérer le projet par son slug
            // Le Use Case vérifie que le projet est publié
            $project = $this->getProjectBySlug->execute($slug);

            return view('projects.show', [
                'project' => $project,
            ]);

        } catch (ProjectNotFoundException $e) {
            // Retourner une erreur 404 si le projet n'existe pas
            abort(404, 'Projet non trouvé');
        }
    }
}
