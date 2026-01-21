import axios, { AxiosInstance, AxiosError } from 'axios';

/**
 * HTTP Client configuré pour l'API Laravel
 */
class HttpClient {
    private client: AxiosInstance;

    constructor() {
        this.client = axios.create({
            baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
            withCredentials: true, // Pour les cookies de session
        });

        // Intercepteur pour les erreurs
        this.client.interceptors.response.use(
            (response) => response,
            (error: AxiosError) => {
                // Gestion centralisée des erreurs
                if (error.response) {
                    console.error('API Error:', error.response.status, error.response.data);
                } else if (error.request) {
                    console.error('Network Error:', error.message);
                }
                return Promise.reject(error);
            }
        );
    }

    get<T>(url: string, config = {}) {
        return this.client.get<T>(url, config);
    }

    post<T>(url: string, data?: unknown, config = {}) {
        return this.client.post<T>(url, data, config);
    }

    put<T>(url: string, data?: unknown, config = {}) {
        return this.client.put<T>(url, data, config);
    }

    delete<T>(url: string, config = {}) {
        return this.client.delete<T>(url, config);
    }
}

export const httpClient = new HttpClient();
