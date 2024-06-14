import './bootstrap';

import axios from 'axios';

function hasApiTokenCookie() {
    const cookies = document.cookie.split(';');
    for (const cookie of cookies) {
        const [key, value] = cookie.trim().split('=');
        if (key === 'api_token') {
        return true;
        }
    }
    return false;
}

function getCookieValue(name) {
    const value = '; ' + document.cookie;
    const parts = value.split('; ' + name + '=');
    if (parts.length === 2) return parts.pop().split(';').shift();
}

async function getToken() {
    try {
        const response = await axios.get('/token');
        const token = response.data.token;
        let expiry = new Date();
        expiry.setMinutes(expiry.getMinutes() + 119);
    
        document.cookie = 'api_token=' + token + '; expires=' + expiry.toUTCString() + '; path=/; samesite=strict';
    } catch (error) {
        window.location.replace('/logout');
    }
}

const apiClient = axios.create();

apiClient.interceptors.request.use(
    async (config) => {
        if (!hasApiTokenCookie()) {
            await getToken();
        }

        config.headers['Authorization'] = 'Bearer ' + getCookieValue('api_token');

        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

function displayQuotes(quotes) {
    const container = document.getElementById('quotes_list');
    container.innerHTML = '';

    for (let i = 0; i < quotes.length; i++) {
        const element = document.getElementById('quote_template');
        const copy = element.cloneNode(true);
        copy.classList.remove('hidden');
        copy.getElementsByTagName('q')[0].innerText = quotes[i];
        container.appendChild(copy);
    }
}

function refreshQuotes() {
    if (window.location.pathname === '/quotes') {
        try {
            apiClient.get('/api/quotes/refresh').then((res) => {
                const quotes = res.data;
                displayQuotes(quotes);
            });
        } catch (error) {
            console.error(error);
        }
    }
}

function fetchQuotes() {
    if (window.location.pathname === '/quotes') {
        try {
            apiClient.get('/api/quotes').then((res) => {
                const quotes = res.data;
                displayQuotes(quotes);
            });
        } catch (error) {
            console.error(error);
        }
    }
}

function getQuotes() {
    if (window.location.pathname === '/quotes') {
        document.getElementById('refresh_quotes').addEventListener('click', () => {
            refreshQuotes();
        });
        document.getElementById('next_quotes').addEventListener('click', () => {
            fetchQuotes();
        });
        try {
            apiClient.get('/api/quotes').then((res) => {
                document.getElementById('loading_spinner').classList.add('hidden');
                fetchQuotes()
            });
        } catch (error) {
            console.error(error);
        }
    }
}

getQuotes()
