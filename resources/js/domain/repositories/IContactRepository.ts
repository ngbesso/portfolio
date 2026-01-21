import { Contact } from '../entities/Contact';

/**
 * Interface : Contact Repository
 */
export interface IContactRepository {
    /**
     * Envoyer un message de contact
     */
    send(contact: Contact): Promise<void>;
}
