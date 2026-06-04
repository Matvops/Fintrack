import { BrowserRouter, Route, Routes } from "react-router-dom";
import { Login } from "../../pages/Login";
import { Home } from "../../pages/Home";
import { Goals } from "../../pages/Goals";
import { Budgets } from "../../pages/Budgets";
import { Transactions } from "../../pages/Transactions";



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

          <Route
            path="/transactions"
            element={<Transactions />}
          />

        </Routes>
      </BrowserRouter>
    </>
  );
}