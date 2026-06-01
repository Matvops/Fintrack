import { PlusIcon } from "lucide-react";
import { ButtonVisibleData } from "../../components/ButtonVisibleData";
import { Heading } from "../../components/Heading";
import { MainTemplate } from "../../templates/MainTemplate";
import style from './style.module.css';
import { useContext, useEffect, useState } from "react";
import { ModalNewBudget } from "./ModalNewBudget";
import type { MainColor } from "../../types/MainColor";
import { budget } from "../../services/budget";
import { message } from "../../adapters/message";
import { UserContext } from "../../contexts/UserContext";
import { BudgetsList } from "../../components/BudgetsList";


export type NewBudgetData = {
  id: number | null,
  name: string,
  limit: string,
  color: MainColor
};


export function Budgets() {

  const { user } = useContext(UserContext);

  const [modalCreateVisible, setModalCreateVisible] = useState(false);
  const [budgets, setBudgets] = useState([]);

  async function create(data: NewBudgetData, event: React.SubmitEvent<HTMLFormElement>) {
    event.preventDefault();

    const response = await budget.create(data);

    if (response.status) {
      message.success(response.message);
      setModalCreateVisible(false);
      getBudgets();
      return;
    }

    message.error(response.message);

  }

  function getBudgets() {

    const response = budget.get(user.id);

    message.dismiss();

    response.then(data => {
      if (data.status) {
        message.success(data.message);
        setBudgets(data.data);
      } else {
        message.error(data.message);
      }
    })
  }

  useEffect(() => {
    getBudgets();
  }, [])

  return (
    <MainTemplate>
      <div className={style.body}>
        <header className={style.header}>
          <Heading text='Orçamento' />

          <ButtonVisibleData />
        </header>

        <section className={style.headerSection}>
          <div className={style.textHeaderSection}>
            <p>{budgets.length} categorias</p>
          </div>

          <div onClick={() => setModalCreateVisible(true)}>
            <button className={style.buttonHeaderSection}><PlusIcon /> Novo orçamento</button>
          </div>
        </section>

        <BudgetsList
          budgets={budgets}
        />

        {modalCreateVisible &&
          <ModalNewBudget
            setVisible={setModalCreateVisible}
            create={create}
          />
        }

      </div>
    </MainTemplate>
  );
}