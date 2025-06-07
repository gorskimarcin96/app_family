import {
    Card,
    CardDescription,
    CardHeader,
    CardTitle
} from "@/components/ui/card.tsx";

export default function LoginPage() {
    return (
        <Card>
            <CardHeader>
                <CardTitle>Homepage</CardTitle>
                <CardDescription>You are logged.</CardDescription>
            </CardHeader>
        </Card>
    );
}
