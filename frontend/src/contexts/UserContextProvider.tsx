import { useState } from "react";
import { initialState } from "./initialState";
import { UserContext } from "./UserContext";

type UserContextProviderProps = {
  children: React.ReactNode
};

export function UserContextProvider({ children }: UserContextProviderProps) {

  const [user, setUser] = useState(initialState);

  return (
    <UserContext.Provider value={{ user, setUser }}>
      {children}
    </UserContext.Provider>
  )
}