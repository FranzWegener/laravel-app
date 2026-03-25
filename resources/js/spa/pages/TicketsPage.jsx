import React, { useEffect, useState } from 'react';
import {Link, useParams} from 'react-router-dom';
import Nav from '../components/Nav';
import TicketsTable from '../components/TicketsTable';
import { listTickets } from '../api/tickets';

export default function TicketsPage() {
    const { customerId } = useParams();
    const [tickets, setTickets] = useState(null);

    useEffect(() => {
        listTickets(customerId).then(setTickets);
    }, [customerId]);

    return (
        <div className="container">
            <Nav />
            <div className="page-header"><h1>Tickets</h1><Link to={`/customer/${customerId}/tickets/new`} className="btn-primary">Neues Ticket</Link></div>
            {tickets === null ? <p>Laden...</p> : <TicketsTable tickets={tickets} />}
        </div>
    );
}
