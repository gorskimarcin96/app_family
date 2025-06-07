import {Navigate, Outlet} from "react-router-dom";
import {useAuth} from "@/features/auth/state.tsx";

export function ProtectedRoute() {
    const {isLogged} = useAuth();

    return isLogged
        ? <Outlet/>
        : <Navigate to="/login" replace/>;
}
