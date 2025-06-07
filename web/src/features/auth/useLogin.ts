import {login, fetchMe} from './api';
import {useAuth} from './state.tsx';

export function useLogin()   {
    const {setAuth} = useAuth();

    return async (email: string, password: string): Promise<void> => {
        const token = await login(email, password);
        const user = await fetchMe(token);
        setAuth(token, user);
    };
}
