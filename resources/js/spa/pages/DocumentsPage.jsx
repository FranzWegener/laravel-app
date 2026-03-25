import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import Nav from '../components/Nav';
import DocumentsTable from '../components/DocumentsTable';
import { listDocuments } from '../api/documents';

export default function DocumentsPage() {
    const { customerId } = useParams();
    const [documents, setDocuments] = useState(null);

    useEffect(() => {
        listDocuments(customerId).then(setDocuments);
    }, [customerId]);

    return (
        <div className="container">
            <Nav />
            <div className="page-header"><h1>Dokumente</h1></div>
            {documents === null ? <p>Laden...</p> : <DocumentsTable documents={documents} />}
        </div>
    );
}
