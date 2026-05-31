import { PlusIcon } from "lucide-react";
import { ButtonVisibleData } from "../../components/ButtonVisibleData";
import { Heading } from "../../components/Heading";
import { MainTemplate } from "../../templates/MainTemplate";
import style from './style.module.css';
import { useState } from "react";
import { ModalNewBudget } from "./ModalNewBudget";
import type { MainColor } from "../../types/MainColor";
import { budget } from "../../services/budget";
import { message } from "../../adapters/message";


export type NewBudgetData = {
  id: number | null,
  name: string,
  limit: string,
  color: MainColor
};


export function Budgets() {

  const [modalCreateVisible, setModalCreateVisible] = useState(false);

  async function create(data: NewBudgetData, event: React.SubmitEvent<HTMLFormElement>) {
    event.preventDefault();

    const response = await budget.create(data);

    if (response.status) {
      message.success(response.message);
      setModalCreateVisible(false);
      return;
    }

    message.error(response.message);

  }

  return (
    <MainTemplate>
      <div className={style.body}>
        <header className={style.header}>
          <Heading text='Orçamento' />

          <ButtonVisibleData />
        </header>

        <section className={style.headerSection}>
          <div className={style.textHeaderSection}>
            <p>0 categorias</p>
          </div>

          <div onClick={() => setModalCreateVisible(true)}>
            <button className={style.buttonHeaderSection}><PlusIcon /> Novo orçamento</button>
          </div>
        </section>

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