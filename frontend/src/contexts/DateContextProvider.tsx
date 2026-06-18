import { useEffect, useState } from "react";
import type { Date } from "../types/Date";
import { initialDate } from "./initialDate";
import { DateContext } from "./DateContext";


type DateContextProviderType = {
  children: React.ReactNode
}

export function DateContextProvider({ children }: DateContextProviderType) {

  const [date, setDate] = useState<Date>(initialDate);

  useEffect(() => {
    console.log(date);
  }, [date]);

  return (
    <DateContext.Provider value={{ date, setDate }}>
      {children}
    </DateContext.Provider>
  );
}