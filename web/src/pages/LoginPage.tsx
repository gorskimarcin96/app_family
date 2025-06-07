import {useState} from 'react';
import {useLogin} from "../features/auth/useLogin.ts";
import {Button} from "@/components/ui/button"
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/components/ui/card"
import {Input} from "@/components/ui/input"
import {Label} from "@/components/ui/label"
import {Alert, AlertTitle} from '@/components/ui/alert.tsx';
import {AlertCircleIcon} from 'lucide-react';

export default function LoginPage() {
    const [error, setError] = useState<string | null>(null);
    const [email, setEmail] = useState<string>('');
    const [password, setPassword] = useState<string>('');
    const login = useLogin();

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        await login(email, password)
            .then(() => setError(null))
            .catch(() => setError('Invalid address email or password'));
    };

    return (
        <Card>
            <CardHeader>
                <CardTitle>Login to your account</CardTitle>
                <CardDescription>
                    Enter your email below to login to your account.
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form onSubmit={handleSubmit}>
                    <div className="flex flex-col gap-6">
                        <div className="grid gap-2">
                            <Label htmlFor="email">Email</Label>
                            <Input
                                id="email"
                                type="email"
                                placeholder="m@example.com"
                                value={email}
                                onChange={e => setEmail(e.target.value)}
                                required
                            />
                        </div>
                        <div className="grid gap-2">
                            <div className="flex items-center">
                                <Label htmlFor="password">Password</Label>
                            </div>
                            <Input id="password"
                                   type="password"
                                   value={password}
                                   onChange={e => setPassword(e.target.value)}
                                   required/>
                        </div>
                        {error !== null ? <Alert variant="destructive">
                            <AlertCircleIcon/>
                            <AlertTitle>{error}</AlertTitle>
                        </Alert> : <></>}
                        <Button type="submit" className="w-full">
                            Login
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    )
}
