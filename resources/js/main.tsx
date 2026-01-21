import React from 'react';
import ReactDOM from 'react-dom/client';
import { App } from './App';

// Import du CSS global (Tailwind)
import '../css/app.css';

// Point d'entrée de l'application React
ReactDOM.createRoot(document.getElementById('root')!).render(
    <React.StrictMode>
        <App />
    </React.StrictMode>
);
