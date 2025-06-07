import {Outlet} from "react-router-dom";
import Navigation from "@/components/navigation/Navigation.tsx";

export default function NavigationLayout() {
    return (
        <div className="min-h-screen flex justify-center">
            <div className="w-full max-w-6xl shadow-md rounded-xl p-6 mt-10">
                <Navigation/>
                <div className="mt-4 shadow-md rounded-xl">
                    <Outlet/>
                </div>
            </div>
        </div>
    )
}
