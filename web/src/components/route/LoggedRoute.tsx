import {Navigate, Outlet} from "react-router-dom";
import {useAuth} from "@/features/auth/state.tsx";

export function LoggedRoute() {
    const {isLogged} = useAuth();

    return isLogged
        ? <Navigate to="/" replace/>
        : <Outlet/>;
}
