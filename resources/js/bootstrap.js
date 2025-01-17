/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';

// Define o axios como uma propriedade global
window.axios = axios;

// Configuração global do Axios
window.axios.defaults.baseURL = 'https://ecommerce-laravel-9b8fcb523cea.herokuapp.com';
window.axios.defaults.withCredentials = true; // Necessário para cookies de sessão (CSRF)
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Função para carregar o token CSRF
const loadCsrfToken = async () => {
    try {
        await window.axios.get('/sanctum/csrf-cookie');
        console.log('Token CSRF carregado com sucesso.');
    } catch (error) {
        console.error('Erro ao carregar o token CSRF:', error);
    }
};

// Carregar o token CSRF ao iniciar a aplicação
loadCsrfToken();

export default loadCsrfToken;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
