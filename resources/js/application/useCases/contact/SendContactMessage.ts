import { IContactRepository } from '@/domain/repositories/IContactRepository';
import { Contact } from '@/domain/entities/Contact';

/**
 * Use Case : Envoyer un message de contact
 */
export class SendContactMessage {
    constructor(private repository: IContactRepository) {}

    async execute(contact: Contact): Promise<void> {
        // Validation métier
        if (!contact.isValid()) {
            throw new Error('Invalid contact data');
        }

        await this.repository.send(contact);
    }
}
