/**
 * Entity : Contact
 * Représente un message de contact (pour le formulaire)
 */
export class Contact {
    constructor(
        public readonly name: string,
        public readonly email: string,
        public readonly subject: string,
        public readonly message: string
    ) {}

    /**
     * Valider que tous les champs requis sont remplis
     */
    isValid(): boolean {
        return (
            this.name.trim().length >= 2 &&
            this.email.trim().length > 0 &&
            this.subject.trim().length >= 5 &&
            this.message.trim().length >= 20
        );
    }
}
