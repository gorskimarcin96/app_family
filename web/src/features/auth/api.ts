import type {User} from "@/features/auth/model.ts";

export async function login(email: string, password: string): Promise<string> {
    const response = await fetch('http://localhost:90/api/login', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({email, password}),
    });

    if (!response.ok) throw new Error('Auth error.');
    const {token} = await response.json();
    return token;
}

export async function fetchMe(token: string): Promise<User> {
    const response = await fetch('http://localhost:90/api/me', {headers: {Authorization: `Bearer ${token}`}});

    if (!response.ok) throw new Error('Me error.');
    return await response.json();
}
