<?php

namespace App\Presentation\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Presentation\Http\Requests\ContactFormRequest;
use App\UseCases\Contact\SendContactMessage;
use App\Infrastructure\Mail\ContactMailService;
use App\Core\Exceptions\{InvalidContactDataException, InvalidEmailException};
use Illuminate\Http\JsonResponse;

/**
 * API Controller : Contact
 *
 * @package App\Presentation\Http\Controllers\Api
 */
class ContactApiController extends Controller
{
    public function __construct(
        private readonly SendContactMessage $sendContactMessage,
        private readonly ContactMailService $mailService
    ) {}

    /**
     * Envoyer un message de contact
     *
     * @param ContactFormRequest $request
     * @return JsonResponse
     *
     * POST /api/contact
     */
    public function store(ContactFormRequest $request): JsonResponse
    {
        try {
            // Envoyer le message
            $contact = $this->sendContactMessage->execute($request->validated());

            // Envoyer les emails (en background avec Queue en production)
            $this->mailService->sendAdminNotification($contact);
            $this->mailService->sendConfirmationToSender($contact);

            return response()->json([
                'message' => 'Message envoyé avec succès',
            ], 201);

        } catch (InvalidContactDataException | InvalidEmailException $e) {
            return response()->json([
                'message' => 'Données invalides',
                'errors' => ['error' => $e->getMessage()],
            ], 422);

        } catch (\Exception $e) {
            logger()->error('Contact API error', [
                'error' => $e->getMessage(),
                'data' => $request->validated(),
            ]);

            return response()->json([
                'message' => 'Une erreur est survenue',
            ], 500);
        }
    }
}
