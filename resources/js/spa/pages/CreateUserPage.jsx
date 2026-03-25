import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import client from '../api/client';

export default function CreateUserPage() {
    const navigate = useNavigate();
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [passwordConfirmation, setPasswordConfirmation] = useState('');
    const [errors, setErrors] = useState([]);
    const [success, setSuccess] = useState(null);
    const [submitting, setSubmitting] = useState(false);

    function handleSubmit(e) {
        e.preventDefault();
        setErrors([]);
        setSuccess(null);
        setSubmitting(true);

        client.post('/users', {
            name,
            email,
            password,
            password_confirmation: passwordConfirmation,
        })
            .then(() => {
                setSuccess('User created successfully.');
                setName('');
                setEmail('');
                setPassword('');
                setPasswordConfirmation('');
            })
            .catch(err => {
                const validationErrors = err.response?.data?.errors;
                if (validationErrors) {
                    setErrors(Object.values(validationErrors).flat());
                } else {
                    setErrors(['An error occurred. Please try again.']);
                }
            })
            .finally(() => setSubmitting(false));
    }

    return (
        <div className="container">
            <div className="page-header">
                <h1>Create User</h1>
            </div>

            {success && (
                <div className="alert-success">{success}</div>
            )}

            {errors.length > 0 && (
                <div className="form-errors">
                    <ul>
                        {errors.map((error, i) => (
                            <li key={i}>{error}</li>
                        ))}
                    </ul>
                </div>
            )}

            <form onSubmit={handleSubmit}>
                <div className="form-group">
                    <label htmlFor="name">Name</label>
                    <input
                        type="text"
                        id="name"
                        maxLength={255}
                        value={name}
                        onChange={e => setName(e.target.value)}
                    />
                </div>

                <div className="form-group">
                    <label htmlFor="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        maxLength={255}
                        value={email}
                        onChange={e => setEmail(e.target.value)}
                    />
                </div>

                <div className="form-group">
                    <label htmlFor="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        value={password}
                        onChange={e => setPassword(e.target.value)}
                    />
                </div>

                <div className="form-group">
                    <label htmlFor="password_confirmation">Confirm Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        value={passwordConfirmation}
                        onChange={e => setPasswordConfirmation(e.target.value)}
                    />
                </div>

                <div className="form-actions">
                    <button type="submit" className="btn-primary" disabled={submitting}>Create User</button>
                </div>
            </form>
        </div>
    );
}
