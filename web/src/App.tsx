import {BrowserRouter as Router, Routes, Route} from "react-router-dom";
import NavigationLayout from "./layout/NavigationLayout";
import HomePage from "./pages/HomePage";
import LoginPage from "./pages/LoginPage";
import {AuthProvider} from "./features/auth/state";
import {ThemeProvider} from "./components/provider/ThemeProvider";
import {ProtectedRoute} from "./components/route/ProtectedRoute";
import {LoggedRoute} from "@/components/route/LoggedRoute.tsx";

function App() {
    return (
        <AuthProvider>
            <ThemeProvider defaultTheme="dark" storageKey="vite-ui-theme">
                <div className="min-h-screen bg-background text-foreground">
                    <Router>
                        <Routes>
                            <Route element={<LoggedRoute/>}>
                                <Route element={<NavigationLayout/>}>
                                    <Route path="/login" element={<LoginPage/>}/>
                                </Route>
                            </Route>
                            <Route element={<ProtectedRoute/>}>
                                <Route element={<NavigationLayout/>}>
                                    <Route path="/" element={<HomePage/>}/>
                                </Route>
                            </Route>
                        </Routes>
                    </Router>
                </div>
            </ThemeProvider>
        </AuthProvider>
    );
}

export default App;
