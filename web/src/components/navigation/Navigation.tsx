import {
    Menubar,
    MenubarContent,
    MenubarMenu,
    MenubarRadioGroup,
    MenubarRadioItem,
    MenubarTrigger,
} from "@/components/ui/menubar"
import {useNavigate} from "react-router-dom"
import {Moon, Sun} from "lucide-react";
import {useAuth} from "@/features/auth/state.tsx";
import {useTheme} from "../provider/ThemeProvider";

export default function Navigation() {
    const navigate = useNavigate()
    const {setTheme} = useTheme();
    const {logout, isLogged} = useAuth();

    return (
        <Menubar className="w-full flex justify-between">
            <div className="flex gap-4">
                {isLogged ? <MenubarMenu>
                    <MenubarTrigger onClick={() => navigate("/")}>
                        Home
                    </MenubarTrigger>
                </MenubarMenu> : <></>}
            </div>
            <div className="flex gap-4 ml-auto">
                {isLogged ? <MenubarMenu>
                    <MenubarTrigger onClick={() => logout()}>
                        Logout
                    </MenubarTrigger>
                </MenubarMenu> : <></>}
                <MenubarMenu>
                    <MenubarTrigger>
                        <Sun
                            className="h-[1.2rem] w-[1.2rem] scale-100 rotate-0 transition-all dark:scale-0 dark:-rotate-90"/>
                        <Moon
                            className="absolute h-[1.2rem] w-[1.2rem] scale-0 rotate-90 transition-all dark:scale-100 dark:rotate-0"/>
                        <span className="sr-only">Toggle theme</span>
                    </MenubarTrigger>
                    <MenubarContent>
                        <MenubarRadioGroup value="benoit">
                            <MenubarRadioItem onClick={() => setTheme("light")}>Light</MenubarRadioItem>
                            <MenubarRadioItem onClick={() => setTheme("dark")}>Dark</MenubarRadioItem>
                            <MenubarRadioItem onClick={() => setTheme("system")}>System</MenubarRadioItem>
                        </MenubarRadioGroup>
                    </MenubarContent>
                </MenubarMenu>
            </div>
        </Menubar>
    );
}
