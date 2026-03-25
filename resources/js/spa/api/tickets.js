import client from './client';

export const listTickets = (customerId) =>
    client.get(`/customer/${customerId}/tickets`).then(r => r.data);

export const createTicket = (customerId, data) =>
    client.post(`/customer/${customerId}/tickets`, data);
