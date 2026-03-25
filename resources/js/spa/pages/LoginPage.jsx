import React, { useState } from 'react';
import {Link, useNavigate} from 'react-router-dom';
import { loginUser } from '../api/login';

export default function LoginPage() {
    const navigate = useNavigate();
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [remember, setRemember] = useState(false);
    const [error, setError] = useState(null);
    const [submitting, setSubmitting] = useState(false);

    function handleSubmit(e) {
        e.preventDefault();
        setError(null);
        setSubmitting(true);

        loginUser(email, password, remember)
            .then(user => {
                navigate('/customer/' + user.id + '/documents', { replace: true });
            })
            .catch(err => {
                const errors = err.response?.data?.errors;
                setError(errors?.email?.[0] ?? 'Login fehlgeschlagen.');
            })
            .finally(() => setSubmitting(false));
    }

    return (
        <div className="container">
            <div className="page-header">
                <h1>Anmelden</h1>
            </div>

            {error && (
                <div className="form-errors">
                    <ul>
                        <li>{error}</li>
                    </ul>
                </div>
            )}

            <form onSubmit={handleSubmit}>
                <div className="form-group">
                    <label htmlFor="email">E-Mail</label>
                    <input
                        id="email"
                        type="email"
                        value={email}
                        onChange={e => setEmail(e.target.value)}
                        required
                        autoFocus
                    />
                </div>

                <div className="form-group">
                    <label htmlFor="password">Passwort</label>
                    <input
                        id="password"
                        type="password"
                        value={password}
                        onChange={e => setPassword(e.target.value)}
                        required
                    />
                </div>

                <div className="form-group">
                    <label>
                        <input
                            type="checkbox"
                            checked={remember}
                            onChange={e => setRemember(e.target.checked)}
                        /> Angemeldet bleiben
                    </label>
                </div>

                <div className="form-actions" style={{display:'flex', justifyContent:'space-between', alignItems:'center'}}>
                    <button type="submit" className="btn-primary" disabled={submitting}>Anmelden</button>
                    <Link to={`/users/create`} className="text-blue-600 hover:underline">Registrieren</Link>
                </div>
            </form>
        </div>
);
}
