import { createContext } from "react";
import { initialDate } from "./initialDate";
import type { Date } from "../types/Date";


type DateContextType = {
    date: Date,
    setDate: React.Dispatch<React.SetStateAction<Date>>
}

export const DateContext = createContext<DateContextType>({date: initialDate, setDate: () => {}});