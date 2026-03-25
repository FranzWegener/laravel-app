import React from 'react';
import { Link, useParams } from 'react-router-dom';

export default function TicketsTable({ tickets }) {
    const { customerId } = useParams();

    if (!tickets.length) {
        return <p>Keine Tickets vorhanden.</p>;
    }

    return (
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Typ</th>
                    <th>Betreff</th>
                    <th>Datum</th>
                </tr>
            </thead>
            <tbody>
                {tickets.map(ticket => (
                    <tr key={ticket.id}>
                        <td>{ticket.status}</td>
                        <td>{ticket.type}</td>
                        <td>{ticket.subject}</td>
                        <td>{ticket.created}</td>
                    </tr>
                ))}
            </tbody>
        </table>
    );
}
