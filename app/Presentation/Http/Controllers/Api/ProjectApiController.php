<?php

namespace App\Presentation\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UseCases\Project\{ListProjects, GetProjectBySlug};
use App\Presentation\Http\Resources\ProjectResource;
use App\Core\Exceptions\ProjectNotFoundException;
use Illuminate\Http\JsonResponse;

/**
 * API Controller : Projets (Public)
 *
 * Endpoints RESTful pour les projets
 *
 * @package App\Presentation\Http\Controllers\Api
 */
class ProjectApiController extends Controller
{
    public function __construct(
        private readonly ListProjects $listProjects,
        private readonly GetProjectBySlug $getProjectBySlug
    ) {}

    /**
     * Liste tous les projets publiés
     *
     * @return JsonResponse
     *
     * GET /api/projects
     */
    public function index(): JsonResponse
    {
        $projects = $this->listProjects->published();

        return response()->json([
            'data' => ProjectResource::collection($projects),
        ]);
    }

    /**
     * Projets mis en avant (featured)
     *
     * @return JsonResponse
     *
     * GET /api/projects/featured
     */
    public function featured(): JsonResponse
    {
        $limit = request()->query('limit', 6);
        $projects = $this->listProjects->featured((int) $limit);

        return response()->json([
            'data' => ProjectResource::collection($projects),
        ]);
    }

    /**
     * Détails d'un projet par slug
     *
     * @param string $slug
     * @return JsonResponse
     *
     * GET /api/projects/{slug}
     */
    public function show(string $slug): JsonResponse
    {
        try {
            $project = $this->getProjectBySlug->execute($slug);

            return response()->json([
                'data' => new ProjectResource($project),
            ]);

        } catch (ProjectNotFoundException $e) {
            return response()->json([
                'message' => 'Project not found',
            ], 404);
        }
    }
}
