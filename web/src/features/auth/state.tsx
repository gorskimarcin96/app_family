import {createContext, useContext, useState, type ReactNode} from 'react';
import type {User} from './model';

type AuthContextType = {
    user: User | null;
    token: string | null;
    isLogged: boolean;
    setAuth: (token: string, user: User) => void;
    logout: () => void;
};

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export function AuthProvider({children}: { children: ReactNode }) {
    const [user, setUser] = useState<User | null>(null);
    const [token, setToken] = useState<string | null>(() => {
        return localStorage.getItem('token');
    });

    const setAuth = (token: string, user: User) => {
        setToken(token);
        setUser(user);
        localStorage.setItem('token', token);
    };

    const logout = () => {
        setToken(null);
        setUser(null);
        localStorage.removeItem('token');
        return true;
    };

    const isLogged: boolean = token !== null;

    return (
        <AuthContext.Provider value={{user, token, isLogged, setAuth, logout}}>
            {children}
        </AuthContext.Provider>
    );
}

export const useAuth = () => {
    const ctx = useContext(AuthContext);

    if (!ctx) throw new Error('useAuth must be used within AuthProvider');
    return ctx;
};
