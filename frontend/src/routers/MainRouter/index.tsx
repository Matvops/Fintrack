import { BrowserRouter, Route, Routes } from "react-router-dom";
import { Login } from "../../pages/Login";
import { Home } from "../../pages/Home";
import { Goals } from "../../pages/Goals";



export function MainRouter() {

  return (
    <>
      <BrowserRouter>
        <Routes>
          <Route
            path="/"
            element={<Login />}
          />

          <Route
            path="/home"
            element={<Home />}
          />

          <Route
            path="/goals"
            element={<Goals />}
          />

        </Routes>
      </BrowserRouter>
    </>
  );
}