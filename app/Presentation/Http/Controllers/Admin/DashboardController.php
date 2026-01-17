<?php

namespace App\Presentation\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\UseCases\Project\ListProjects;
use App\UseCases\Contact\ListContactMessages;
use App\Core\ValueObjects\ProjectStatus;
use Illuminate\View\View;

/**
 * Controller Admin : Tableau de bord
 *
 * Affiche les statistiques et informations importantes
 *
 * @package App\Presentation\Http\Controllers\Admin
 */
class DashboardController extends Controller
{
    public function __construct(
        private readonly ListProjects $listProjects,
        private readonly ListContactMessages $listContactMessages
    ) {}

    /**
     * Afficher le dashboard admin
     *
     * Route : GET /admin
     *
     * @return View
     */
    public function index(): View
    {
        // Statistiques des projets
        $stats = [
            'total_projects' => count($this->listProjects->all()),
            'published_projects' => count($this->listProjects->published()),
            'draft_projects' => count($this->listProjects->byStatus(ProjectStatus::DRAFT)),
            'unread_messages' => $this->listContactMessages->countUnread(),
        ];

        // Projets récents (les 5 derniers)
        $recentProjects = array_slice($this->listProjects->all(), 0, 5);

        // Messages non lus (les 5 derniers)
        $unreadMessages = array_slice($this->listContactMessages->unread(), 0, 5);

        return view('admin.dashboard', compact('stats', 'recentProjects', 'unreadMessages'));
    }
}
