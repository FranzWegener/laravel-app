import React from 'react';

export default function DocumentsTable({ documents }) {
    if (!documents.length) {
        return <p>Keine Dokumente vorhanden.</p>;
    }

    return (
        <table>
            <thead>
                <tr>
                    <th>Typ</th>
                    <th>Name</th>
                    <th>Datum</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {documents.map(doc => (
                    <tr key={doc.id}>
                        <td>{doc.type}</td>
                        <td>{doc.name}</td>
                        <td>{doc.created}</td>
                        <td>
                            <a href={`/customer/${doc.customer_id}/document/${doc.id}`}>
                                Herunterladen
                            </a>
                        </td>
                    </tr>
                ))}
            </tbody>
        </table>
    );
}
