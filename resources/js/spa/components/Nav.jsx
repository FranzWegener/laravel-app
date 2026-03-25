import React from 'react';
import { Link, useParams } from 'react-router-dom';

export default function Nav() {
    const { customerId } = useParams();

    async function handleLogout(e) {
        e.preventDefault();
        await fetch('/api/logout', { method: 'POST' });
        window.location.href = '/app/login';
    }

    return (
        <nav className="main-nav">
            <Link to={`/customer/${customerId}/documents`}>Dokumente</Link>
            <Link to={`/customer/${customerId}/tickets`}>Tickets</Link>
            <button type="button" onClick={handleLogout}>Abmelden</button>
        </nav>
    );
}
