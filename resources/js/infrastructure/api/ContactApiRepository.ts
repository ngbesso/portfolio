import { IContactRepository } from '@/domain/repositories/IContactRepository';
import { Contact } from '@/domain/entities/Contact';
import { httpClient } from './httpClient';

/**
 * Repository : Implémentation API pour le contact
 */
export class ContactApiRepository implements IContactRepository {
    async send(contact: Contact): Promise<void> {
        await httpClient.post('/api/contact', {
            name: contact.name,
            email: contact.email,
            subject: contact.subject,
            message: contact.message,
        });
    }
}
