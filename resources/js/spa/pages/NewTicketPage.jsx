import React from 'react';
import Nav from '../components/Nav';
import NewTicketForm from '../components/NewTicketForm';

export default function NewTicketPage() {
    return (
        <div className="container">
            <Nav />
            <div className="page-header"><h1>Neues Ticket</h1></div>
            <NewTicketForm />
        </div>
    );
}
