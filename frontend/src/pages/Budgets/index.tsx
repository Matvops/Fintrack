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
import type { Budget } from "../../types/Budget";
import { ModalEditBudget } from "./ModalEditBudget";


export type NewBudgetData = {
  id: number | null,
  name: string,
  limit: string,
  color: MainColor
};


export function Budgets() {

  const { user } = useContext(UserContext);

  const [modalCreateVisible, setModalCreateVisible] = useState(false);
  const [modalEditVisible, setModalEditVisibile] = useState(false);
  const [budgets, setBudgets] = useState([]);
  const [selectedBudget, setSelectedBudget] = useState<Budget>();

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

  async function excluir(id: number, event: React.MouseEvent<HTMLButtonElement, MouseEvent>) {
    event.preventDefault();
    const response = await budget.delete(id);

    if (response.status) {
      message.success(response.message);
      setModalEditVisibile(false);
      getBudgets();
      return;
    }

    message.error(response.message);
  }

  async function edit(data: Budget, event: React.SubmitEvent<HTMLFormElement>) {
    event.preventDefault();

    const response = await budget.edit(data);

    if (response.status) {
      message.success(response.message);
      setModalEditVisibile(false);
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
          setBudget={setSelectedBudget}
          setModalVisible={setModalEditVisibile}
        />

        {modalCreateVisible &&
          <ModalNewBudget
            setVisible={setModalCreateVisible}
            create={create}
          />
        }

        {modalEditVisible && selectedBudget &&
          <ModalEditBudget
            budget={selectedBudget}
            setVisible={setModalEditVisibile}
            edit={edit}
            excluir={excluir}
          />
        }

      </div>
    </MainTemplate>
  );
}