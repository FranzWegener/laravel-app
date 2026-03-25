import client from './client';

export function loginUser(email, password, remember = false) {
    return client.post('/login', { email, password, remember })
        .then(res => res.data);
}
