<?php

namespace App\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\UseCases\Project\ListProjects;
use App\UseCases\Skill\ListSkillsByCategory;
use Illuminate\View\View;

/**
 * Controller : Page d'accueil
 *
 * Responsabilités :
 * - Afficher la page d'accueil du portfolio
 * - Récupérer les projets featured
 * - Récupérer les compétences groupées par catégorie
 *
 * Principe :
 * Le controller ne contient AUCUNE logique métier.
 * Il orchestre les Use Cases et passe les données à la vue.
 *
 * @package App\Presentation\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Injection des Use Cases nécessaires
     */
    public function __construct(
        private readonly ListProjects $listProjects,
        private readonly ListSkillsByCategory $listSkills
    ) {}

    /**
     * Afficher la page d'accueil
     *
     * Route : GET /
     *
     * @return View
     */
    public function index(): View
    {
        // 1. Récupérer les projets mis en avant (featured)
        // Limité à 6 projets pour la page d'accueil
        $featuredProjects = $this->listProjects->featured(6);

        // 2. Récupérer les compétences groupées par catégorie
        $skillsByCategory = $this->listSkills->execute();

        // 3. Passer les données à la vue
        return view('home', [
            'featuredProjects' => $featuredProjects,
            'skillsByCategory' => $skillsByCategory,
        ]);
    }
}
