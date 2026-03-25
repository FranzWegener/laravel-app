import { useState, useEffect } from 'react';
import { getMe } from '../api/auth';

export function useCurrentUser() {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        getMe()
            .then(setUser)
            .catch(() => { window.location.href = '/app/login'; })
            .finally(() => setLoading(false));
    }, []);

    return { user, loading };
}
