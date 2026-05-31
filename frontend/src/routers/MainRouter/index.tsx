import { BrowserRouter, Route, Routes } from "react-router-dom";
import { Login } from "../../pages/Login";
import { Home } from "../../pages/Home";
import { Goals } from "../../pages/Goals";
import { Budgets } from "../../pages/Budgets";



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

          <Route
            path="/budgets"
            element={<Budgets />}
          />

        </Routes>
      </BrowserRouter>
    </>
  );
}