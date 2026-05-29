import { Pencil, PlusIcon } from 'lucide-react';
import { ButtonVisibleData } from '../../components/ButtonVisibleData';
import { Heading } from '../../components/Heading';
import { MainTemplate } from '../../templates/MainTemplate';
import style from './style.module.css';
import { ModalNewGoal } from './ModalNewGoal';
import { useState } from 'react';
import type { MainColor } from '../../types/MainColor';
import { goals } from '../../services/goals';
import { message } from '../../adapters/message';

export type NewGoalData = {
  id: number|null,
  name: string,
  balance: string,
  balanceTarget: string,
  color: MainColor
};

export function Goals() {

  const [modalVisible, setModalVisible] = useState(false);

  async function cadastrar(data: NewGoalData, event: React.SubmitEvent<HTMLFormElement>) {
    event.preventDefault();
    const response = await goals.create(data);

    if (response.status) {
      message.success(response.message);
      setModalVisible(false);
      return;
    }

    message.error(response.message);
  }

  return (
    <MainTemplate>

      <div className={style.body}>
        <header className={style.header}>
          <Heading text='Metas' />

          <ButtonVisibleData />
        </header>

        <section className={style.headerSection}>
          <div className={style.textHeaderSection}>
            <p>0 metas cadastradas</p>
          </div>

          <div onClick={() => setModalVisible(prevState => !prevState)}>
            <button className={style.buttonHeaderSection}><PlusIcon /> Nova meta</button>
          </div>
        </section>

        <main className={style.goalsList}>
          <div className={style.card}>
            <div className={style.headerCard}>

              <div>
                <h2 className={style.headerTitle}>Reserva de Emergência</h2>
                <span className={style.headerSubTitle}>57% concluído</span>
              </div>

              <div className={style.cardValues}>
                <div>
                  <h2 className={style.headerTitle}>R$ 8.500,00</h2>
                  <span className={style.headerSubTitle}>de R$ 15.000,00</span>
                </div>
                <button className={style.buttonEdit}>
                  <Pencil /> Editar
                </button>
              </div>
            </div>

            <progress className={style.progressBar} value={0.2} />

            <div>
              <span className={style.headerSubTitle}>Faltam R$ 6.500,00 para a meta</span>
            </div>
          </div>

          <div className={style.card}>
            <div className={style.headerCard}>

              <div>
                <h2 className={style.headerTitle}>Reserva de Emergência</h2>
                <span className={style.headerSubTitle}>57% concluído</span>
              </div>

              <div className={style.cardValues}>
                <div>
                  <h2 className={style.headerTitle}>R$ 8.500,00</h2>
                  <span className={style.headerSubTitle}>de R$ 15.000,00</span>
                </div>
                <button className={style.buttonEdit}>
                  <Pencil /> Editar
                </button>
              </div>
            </div>

            <progress className={style.progressBar} value={0.57} />

            <div>
              <span className={style.headerSubTitle}>Faltam R$ 6.500,00 para a meta</span>
            </div>
          </div>

          <div className={style.card}>
            <div className={style.headerCard}>

              <div>
                <h2 className={style.headerTitle}>Reserva de Emergência</h2>
                <span className={style.headerSubTitle}>57% concluído</span>
              </div>

              <div className={style.cardValues}>
                <div>
                  <h2 className={style.headerTitle}>R$ 8.500,00</h2>
                  <span className={style.headerSubTitle}>de R$ 15.000,00</span>
                </div>
                <button className={style.buttonEdit}>
                  <Pencil /> Editar
                </button>
              </div>
            </div>

            <progress className={style.progressBar} value={0.5} />

            <div>
              <span className={style.headerSubTitle}>Faltam R$ 6.500,00 para a meta</span>
            </div>
          </div>
        </main>

        {modalVisible && (
          <ModalNewGoal
            setVisible={setModalVisible}
            cadastrar={cadastrar}
          />
        )}
      </div>
    </MainTemplate>
  );
}