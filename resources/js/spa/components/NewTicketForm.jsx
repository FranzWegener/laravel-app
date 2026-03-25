import React, { useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import { createTicket } from '../api/tickets';

export default function NewTicketForm() {
    const { customerId } = useParams();
    const navigate = useNavigate();
    const [errors, setErrors] = useState({});
    const [submitting, setSubmitting] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setSubmitting(true);
        setErrors({});

        const data = Object.fromEntries(new FormData(e.target));

        try {
            await createTicket(customerId, data);
            navigate(`/customer/${customerId}/tickets`);
        } catch (err) {
            if (err.response?.status === 422) {
                setErrors(err.response.data.errors ?? {});
            }
        } finally {
            setSubmitting(false);
        }
    };

    return (
        <form onSubmit={handleSubmit} className="form-group">
            <div>
                <label>Typ</label>
                <select name="type">
                    <option value="problem">Problem</option>
                    <option value="request">Anfrage</option>
                </select>
                {errors.type && <span className="form-errors">{errors.type[0]}</span>}
            </div>
            <div>
                <label>Betreff</label>
                <input type="text" name="subject" />
                {errors.subject && <span className="form-errors">{errors.subject[0]}</span>}
            </div>
            <div>
                <label>Nachricht</label>
                <textarea name="content" rows={5} />
                {errors.content && <span className="form-errors">{errors.content[0]}</span>}
            </div>
            <button type="submit" className="btn-primary" disabled={submitting}>
                Absenden
            </button>
        </form>
    );
}
