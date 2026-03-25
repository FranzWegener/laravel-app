import client from './client';

export const getMe = () => client.get('/me').then(r => r.data);
