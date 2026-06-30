import { PlusIcon } from "lucide-react";
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
import { DateContext } from "../../contexts/DateContext";
import { ButtonTextIcon } from "../../components/ButtonTextIcon";


export type NewBudgetData = {
  id: number | null,
  name: string,
  limit: string,
  color: MainColor
};


export function Budgets() {

  const { user } = useContext(UserContext);
  const { date } = useContext(DateContext);

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

    const dateSelected = new Date(date.date);

    const response = budget.get(user.id, dateSelected.getTime());

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
    document.title = 'Budgets'
  }, []);

  useEffect(() => {
     getBudgets(); 
  }, [date])

  return (
    <MainTemplate title="Orçamentos">
        <section className={style.headerSection}>
          <div className={style.textHeaderSection}>
            <p>{budgets.length} categorias</p>
          </div>

          <div onClick={() => setModalCreateVisible(true)}>
            <ButtonTextIcon 
              text="Novo orçamento"
              icon={<PlusIcon />}
            />
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

    </MainTemplate>
  );
}