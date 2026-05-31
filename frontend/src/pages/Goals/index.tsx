import { PlusIcon } from 'lucide-react';
import { ButtonVisibleData } from '../../components/ButtonVisibleData';
import { Heading } from '../../components/Heading';
import { MainTemplate } from '../../templates/MainTemplate';
import style from './style.module.css';
import { ModalNewGoal } from './ModalNewGoal';
import { useContext, useEffect, useState } from 'react';
import type { MainColor } from '../../types/MainColor';
import { message } from '../../adapters/message';
import { goal } from '../../services/goal';
import { UserContext } from '../../contexts/UserContext';
import { GoalsList } from '../../components/GoalsList';

export type NewGoalData = {
  id: number|null,
  name: string,
  balance: string,
  balanceTarget: string,
  color: MainColor
};

export function Goals() {

  const { user } = useContext(UserContext);
  const [modalVisible, setModalVisible] = useState(false);
  const [goals, setGoals] = useState([]);

  async function cadastrar(data: NewGoalData, event: React.SubmitEvent<HTMLFormElement>) {
    event.preventDefault();
    const response = await goal.create(data);

    if (response.status) {
      message.success(response.message);
      setModalVisible(false);
      getGoals();
      return;
    }

    message.error(response.message);
  }

  function getGoals() {
    const response = goal.get(user.id);

    message.dismiss();


    response.then(data => {
      if(data.message) {
        message.success(data.message);
        setGoals(data.data);
      } else {
        message.error(data.message);
      }
    })
  }

  useEffect(() => {
      getGoals();
  }, []);

  return (
    <MainTemplate>

      <div className={style.body}>
        <header className={style.header}>
          <Heading text='Metas' />

          <ButtonVisibleData />
        </header>

        <section className={style.headerSection}>
          <div className={style.textHeaderSection}>
            <p>{goals.length} metas cadastradas</p>
          </div>

          <div onClick={() => setModalVisible(prevState => !prevState)}>
            <button className={style.buttonHeaderSection}><PlusIcon /> Nova meta</button>
          </div>
        </section>

      <GoalsList
        goals={goals}
      />

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