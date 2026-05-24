import { createContext } from "react";
import type { User } from "../types/User";
import { initialState } from "./initialState";


type UserContextType = {
  user: User,
  setUser: React.Dispatch<React.SetStateAction<User>>
}

export const UserContext = createContext<UserContextType>({user: initialState, setUser: () => {}});

