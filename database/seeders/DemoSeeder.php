<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectModel;
use App\Models\SkillModel;

/**
 * Seeder : Données de démonstration
 *
 * Usage : php artisan db:seed --class=DemoSeeder
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Créer des projets de démonstration
        $this->createProjects();

        // Créer des compétences de démonstration
        $this->createSkills();
    }

    private function createProjects(): void
    {
        $projects = [
            [
                'title' => 'E-commerce Laravel',
                'slug' => 'e-commerce-laravel',
                'description' => 'Plateforme e-commerce complète développée avec Laravel. Gestion des produits, panier d\'achat, paiement en ligne, système d\'administration complet.',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Stripe', 'Tailwind CSS'],
                'url' => 'https://demo-ecommerce.example.com',
                'github_url' => 'https://github.com/example/ecommerce-laravel',
                'status' => 'published',
                'featured' => true,
                'order' => 1,
            ],
            [
                'title' => 'API REST Blog',
                'slug' => 'api-rest-blog',
                'description' => 'API RESTful pour un système de blog. Authentification JWT, CRUD complet des articles, système de commentaires, gestion des catégories et tags.',
                'technologies' => ['Laravel', 'Sanctum', 'MySQL', 'PHPUnit'],
                'url' => 'https://api-blog.example.com/documentation',
                'github_url' => 'https://github.com/example/blog-api',
                'status' => 'published',
                'featured' => true,
                'order' => 2,
            ],
            [
                'title' => 'Dashboard Analytics',
                'slug' => 'dashboard-analytics',
                'description' => 'Tableau de bord interactif pour visualiser des données analytiques. Graphiques en temps réel, exports PDF et Excel, filtres avancés.',
                'technologies' => ['Laravel', 'Livewire', 'Chart.js', 'PostgreSQL', 'Redis'],
                'url' => null,
                'github_url' => 'https://github.com/example/analytics-dashboard',
                'status' => 'published',
                'featured' => true,
                'order' => 3,
            ],
            [
                'title' => 'Application Mobile avec API',
                'slug' => 'application-mobile-api',
                'description' => 'Backend API pour une application mobile de réservation. Système de notifications push, géolocalisation, paiements intégrés.',
                'technologies' => ['Laravel', 'Firebase', 'Pusher', 'MongoDB'],
                'url' => null,
                'github_url' => null,
                'status' => 'published',
                'featured' => false,
                'order' => 4,
            ],
        ];

        foreach ($projects as $projectData) {
            ProjectModel::create($projectData);
        }

        $this->command->info('✅ 4 projets de démonstration créés.');
    }

    private function createSkills(): void
    {
        $skills = [
            // Backend
            ['name' => 'PHP', 'category' => 'Backend', 'level' => 'expert', 'order' => 1],
            ['name' => 'Laravel', 'category' => 'Backend', 'level' => 'expert', 'order' => 2],
            ['name' => 'Symfony', 'category' => 'Backend', 'level' => 'advanced', 'order' => 3],
            ['name' => 'MySQL', 'category' => 'Backend', 'level' => 'advanced', 'order' => 4],
            ['name' => 'PostgreSQL', 'category' => 'Backend', 'level' => 'intermediate', 'order' => 5],
            ['name' => 'Redis', 'category' => 'Backend', 'level' => 'intermediate', 'order' => 6],

            // Frontend
            ['name' => 'HTML/CSS', 'category' => 'Frontend', 'level' => 'expert', 'order' => 1],
            ['name' => 'JavaScript', 'category' => 'Frontend', 'level' => 'advanced', 'order' => 2],
            ['name' => 'Vue.js', 'category' => 'Frontend', 'level' => 'advanced', 'order' => 3],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend', 'level' => 'expert', 'order' => 4],
            ['name' => 'Alpine.js', 'category' => 'Frontend', 'level' => 'intermediate', 'order' => 5],

            // DevOps
            ['name' => 'Git', 'category' => 'DevOps', 'level' => 'expert', 'order' => 1],
            ['name' => 'Docker', 'category' => 'DevOps', 'level' => 'intermediate', 'order' => 2],
            ['name' => 'Linux', 'category' => 'DevOps', 'level' => 'advanced', 'order' => 3],
            ['name' => 'CI/CD', 'category' => 'DevOps', 'level' => 'intermediate', 'order' => 4],

            // Outils
            ['name' => 'PHPUnit', 'category' => 'Testing', 'level' => 'advanced', 'order' => 1],
            ['name' => 'Pest', 'category' => 'Testing', 'level' => 'intermediate', 'order' => 2],
        ];

        foreach ($skills as $skillData) {
            $skillData['slug'] = \Illuminate\Support\Str::slug($skillData['name']);
            SkillModel::create($skillData);
        }

        $this->command->info('✅ 17 compétences de démonstration créées.');
    }
}
