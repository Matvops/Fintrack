import { BrowserRouter, Routes } from "react-router-dom";


type MainRouterType = {
  children: React.ReactNode
}

export function MainRouter({ children }: MainRouterType) {

  return (
    <>
      <BrowserRouter>
        <Routes>
          {children}
        </Routes>
      </BrowserRouter>
    </>
  );
}