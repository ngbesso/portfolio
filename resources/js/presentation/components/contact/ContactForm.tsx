import React from 'react';
import { useForm } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import { z } from 'zod';
import { Contact } from '@/domain/entities/Contact';
import { useContactForm } from '@/application/hooks/useContactForm';
import { Button } from '../common/Button';

const contactSchema = z.object({
    name: z.string().min(2, 'Le nom doit contenir au moins 2 caractères'),
    email: z.string().email('Email invalide'),
    subject: z.string().min(5, 'Le sujet doit contenir au moins 5 caractères'),
    message: z.string().min(20, 'Le message doit contenir au moins 20 caractères'),
});

type ContactFormData = z.infer<typeof contactSchema>;

export function ContactForm() {
    const {
        register,
        handleSubmit,
        formState: { errors },
        reset,
    } = useForm<ContactFormData>({
        resolver: zodResolver(contactSchema),
    });

    const { mutate, isPending, isSuccess, isError } = useContactForm();

    const onSubmit = (data: ContactFormData) => {
        const contact = new Contact(data.name, data.email, data.subject, data.message);
        mutate(contact, {
            onSuccess: () => {
                reset();
            },
        });
    };

    return (
        <form onSubmit={handleSubmit(onSubmit)} className="space-y-6">
            {/* Nom */}
            <div>
                <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-2">
                    Nom *
                </label>
                <input
                    id="name"
                    type="text"
                    {...register('name')}
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
                {errors.name && <p className="mt-1 text-sm text-red-600">{errors.name.message}</p>}
            </div>

            {/* Email */}
            <div>
                <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">
                    Email *
                </label>
                <input
                    id="email"
                    type="email"
                    {...register('email')}
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
                {errors.email && <p className="mt-1 text-sm text-red-600">{errors.email.message}</p>}
            </div>

            {/* Sujet */}
            <div>
                <label htmlFor="subject" className="block text-sm font-medium text-gray-700 mb-2">
                    Sujet *
                </label>
                <input
                    id="subject"
                    type="text"
                    {...register('subject')}
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
                {errors.subject && <p className="mt-1 text-sm text-red-600">{errors.subject.message}</p>}
            </div>

            {/* Message */}
            <div>
                <label htmlFor="message" className="block text-sm font-medium text-gray-700 mb-2">
                    Message *
                </label>
                <textarea
                    id="message"
                    rows={6}
                    {...register('message')}
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                />
                {errors.message && <p className="mt-1 text-sm text-red-600">{errors.message.message}</p>}
            </div>

            {/* Messages de statut */}
            {isSuccess && (
                <div className="rounded-lg bg-green-50 p-4">
                    <p className="text-green-800">✓ Message envoyé avec succès !</p>
                </div>
            )}

            {isError && (
                <div className="rounded-lg bg-red-50 p-4">
                    <p className="text-red-800">✗ Une erreur est survenue. Veuillez réessayer.</p>
                </div>
            )}

            {/* Bouton d'envoi */}
            <Button type="submit" variant="primary" size="lg" isLoading={isPending} className="w-full">
                Envoyer le message
            </Button>
        </form>
    );
}
