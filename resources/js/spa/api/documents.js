import client from './client';

export const listDocuments = (customerId) =>
    client.get(`/customer/${customerId}/documents`).then(r => r.data);
