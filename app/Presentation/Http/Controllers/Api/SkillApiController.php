<?php

namespace App\Presentation\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UseCases\Skill\ListSkillsByCategory;
use App\Presentation\Http\Resources\SkillResource;
use Illuminate\Http\JsonResponse;

/**
 * API Controller : Compétences
 *
 * @package App\Presentation\Http\Controllers\Api
 */
class SkillApiController extends Controller
{
    public function __construct(
        private readonly ListSkillsByCategory $listSkills
    ) {}

    /**
     * Liste des compétences groupées par catégorie
     *
     * @return JsonResponse
     *
     * GET /api/skills
     */
    public function index(): JsonResponse
    {
        $skillsByCategory = $this->listSkills->execute();

        // Transformer en format API
        $data = [];
        foreach ($skillsByCategory as $category => $skills) {
            $data[] = [
                'category' => $category,
                'skills' => SkillResource::collection($skills),
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }
}
