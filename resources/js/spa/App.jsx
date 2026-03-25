import React from 'react';
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import { useCurrentUser } from './hooks/useCurrentUser';
import DocumentsPage from './pages/DocumentsPage';
import TicketsPage from './pages/TicketsPage';
import NewTicketPage from './pages/NewTicketPage';
import LoginPage from './pages/LoginPage';
import CreateUserPage from './pages/CreateUserPage';

function AuthGuard({ children }) {
    const { user, loading } = useCurrentUser();

    if (loading) return null;
    if (!user) return null; // useCurrentUser redirects to /app/login on 401

    return children;
}

export default function App() {
    return (
        <BrowserRouter basename="/app">
            <Routes>
                <Route path="/login" element={<LoginPage />} />
                <Route path="/users/create" element={<CreateUserPage />} />
                <Route path="*" element={
                    <AuthGuard>
                        <Routes>
                            <Route path="/customer/:customerId/documents" element={<DocumentsPage />} />
                            <Route path="/customer/:customerId/tickets" element={<TicketsPage />} />
                            <Route path="/customer/:customerId/tickets/new" element={<NewTicketPage />} />
                            <Route path="*" element={<Navigate to="/login" replace />} />
                        </Routes>
                    </AuthGuard>
                } />
            </Routes>
        </BrowserRouter>
    );
}
