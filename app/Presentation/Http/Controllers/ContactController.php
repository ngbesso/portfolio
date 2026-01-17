<?php

namespace App\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Presentation\Http\Requests\ContactFormRequest;
use App\UseCases\Contact\SendContactMessage;
use App\Infrastructure\Mail\ContactMailService;
use App\Core\Exceptions\InvalidContactDataException;
use App\Core\Exceptions\InvalidEmailException;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Controller : Formulaire de contact
 *
 * @package App\Presentation\Http\Controllers
 */
class ContactController extends Controller
{
    public function __construct(
        private readonly SendContactMessage $sendContactMessage,
        private readonly ContactMailService $mailService
    ) {}

    /**
     * Afficher le formulaire de contact
     *
     * Route : GET /contact
     *
     * @return View
     */
    public function show(): View
    {
        return view('contact');
    }

    /**
     * Traiter l'envoi du formulaire de contact
     *
     * Route : POST /contact
     *
     * Flow :
     * 1. Valider les données (FormRequest)
     * 2. Envoyer le message (Use Case)
     * 3. Envoyer les emails (Service)
     * 4. Rediriger avec message de succès
     *
     * @param ContactFormRequest $request
     * @return RedirectResponse
     */
    public function store(ContactFormRequest $request): RedirectResponse
    {
        try {
            // 1. Envoyer le message de contact (sauvegarde en DB)
            $contact = $this->sendContactMessage->execute($request->validated());

            // 2. Envoyer les emails de notification
            // Note : En production, utilisez une Queue pour les emails
            $this->mailService->sendAdminNotification($contact);
            $this->mailService->sendConfirmationToSender($contact);

            // 3. Rediriger avec message de succès
            return redirect()
                ->back()
                ->with('success', 'Merci pour votre message ! Je vous répondrai dans les plus brefs délais.');

        } catch (InvalidContactDataException | InvalidEmailException $e) {
            // Erreur de validation métier
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();

        } catch (\Exception $e) {
            // Erreur inattendue
            logger()->error('Contact form error', [
                'error' => $e->getMessage(),
                'data' => $request->validated(),
            ]);

            return redirect()
                ->back()
                ->withErrors(['error' => 'Une erreur est survenue. Veuillez réessayer plus tard.'])
                ->withInput();
        }
    }
}

