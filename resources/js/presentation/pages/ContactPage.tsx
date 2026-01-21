import React from 'react';
import { Layout } from '../components/layout/Layout';
import { ContactForm } from '../components/contact/ContactForm';

export function ContactPage() {
    return (
        <Layout>
            <div className="container mx-auto px-4 py-16">
                <div className="max-w-2xl mx-auto">
                    <h1 className="text-4xl font-bold text-gray-900 mb-4">Me Contacter</h1>
                    <p className="text-gray-600 mb-8">
                        Une question ? Un projet ? N'hésitez pas à me contacter via le formulaire ci-dessous.
                        Je vous répondrai dans les plus brefs délais !
                    </p>
                    <ContactForm />
                </div>
            </div>
        </Layout>
    );
}


