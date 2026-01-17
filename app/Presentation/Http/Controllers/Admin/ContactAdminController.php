<?php

namespace App\Presentation\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\UseCases\Contact\{ListContactMessages, MarkMessageAsRead};
use App\Infrastructure\Repositories\EloquentContactRepository;
use App\Core\Exceptions\ContactNotFoundException;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Controller Admin : Gestion des messages de contact
 *
 * @package App\Presentation\Http\Controllers\Admin
 */
class ContactAdminController extends Controller
{
    public function __construct(
        private readonly ListContactMessages $listContactMessages,
        private readonly MarkMessageAsRead $markMessageAsRead,
        private readonly EloquentContactRepository $contactRepository
    ) {}

    /**
     * Liste de tous les messages de contact
     *
     * Route : GET /admin/contacts
     */
    public function index(): View
    {
        $contacts = $this->listContactMessages->all();
        $unreadCount = $this->listContactMessages->countUnread();

        return view('admin.contacts.index', compact('contacts', 'unreadCount'));
    }

    /**
     * Afficher un message de contact
     *
     * Route : GET /admin/contacts/{id}
     */
    public function show(int $id): View|RedirectResponse
    {
        try {
            $contact = $this->contactRepository->findById($id);

            if (!$contact) {
                throw ContactNotFoundException::withId($id);
            }

            // Marquer comme lu automatiquement à l'ouverture
            if (!$contact->isRead()) {
                $this->markMessageAsRead->execute($id);
                // Récupérer à nouveau pour avoir la date de lecture
                $contact = $this->contactRepository->findById($id);
            }

            return view('admin.contacts.show', compact('contact'));

        } catch (ContactNotFoundException $e) {
            return redirect()
                ->route('admin.contacts.index')
                ->withErrors(['error' => 'Message non trouvé.']);
        }
    }

    /**
     * Marquer un message comme lu/non lu
     *
     * Route : POST /admin/contacts/{id}/toggle-read
     */
    public function toggleRead(int $id): RedirectResponse
    {
        try {
            $contact = $this->contactRepository->findById($id);

            if (!$contact) {
                throw ContactNotFoundException::withId($id);
            }

            if ($contact->isRead()) {
                $contact->markAsUnread();
                $this->contactRepository->update($contact);
                $message = 'Message marqué comme non lu.';
            } else {
                $this->markMessageAsRead->execute($id);
                $message = 'Message marqué comme lu.';
            }

            return redirect()
                ->back()
                ->with('success', $message);

        } catch (ContactNotFoundException $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Message non trouvé.']);
        }
    }

    /**
     * Supprimer un message
     *
     * Route : DELETE /admin/contacts/{id}
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $deleted = $this->contactRepository->delete($id);

            if (!$deleted) {
                throw ContactNotFoundException::withId($id);
            }

            return redirect()
                ->route('admin.contacts.index')
                ->with('success', 'Message supprimé avec succès !');

        } catch (ContactNotFoundException $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Message non trouvé.']);
        }
    }
}
