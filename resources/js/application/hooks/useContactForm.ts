import { useMutation } from '@tanstack/react-query';
import { container } from '@/config/container';
import { Contact } from '@/domain/entities/Contact';

/**
 * Custom Hook : Envoyer un message de contact
 */
export function useContactForm() {
    const sendContactMessage = container.getSendContactMessage();

    return useMutation({
        mutationFn: (contact: Contact) => sendContactMessage.execute(contact),
    });
}
