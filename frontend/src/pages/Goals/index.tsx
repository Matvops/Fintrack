import { PlusIcon } from 'lucide-react';
import { MainTemplate } from '../../templates/MainTemplate';
import style from './style.module.css';
import { ModalNewGoal } from './ModalNewGoal';
import { useContext, useEffect, useState } from 'react';
import type { MainColor } from '../../types/MainColor';
import { message } from '../../adapters/message';
import { goal } from '../../services/goal';
import { UserContext } from '../../contexts/UserContext';
import { GoalsList } from '../../components/GoalsList';
import { ModalEditGoal } from './ModalEditGoal';
import type { Goal } from '../../types/Goal';

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
  const [modalEditVisible, setModalEditVisible] = useState(false);
  const [goals, setGoals] = useState([]);
  const [selectedGoal, setSelectedGoal] = useState<Goal>();

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

  async function editar(data: Goal, event: React.SubmitEvent<HTMLFormElement>) {
    event.preventDefault();
    const response = await goal.edit(data);

    if (response.status) {
      message.success(response.message);
      setModalEditVisible(false);
      getGoals();
      return;
    }

    message.error(response.message);
  }

  async function excluir(id: number, event: React.MouseEvent<HTMLButtonElement, MouseEvent>) {
    event.preventDefault();
    const response = await goal.delete(id);

    if (response.status) {
      message.success(response.message);
      setModalEditVisible(false);
      getGoals();
      return;
    }

    message.error(response.message);
  }

  function getGoals() {
    const response = goal.get(user.id);

    message.dismiss();


    response.then(data => {
      if(data.status) {
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
    <MainTemplate title='Metas'>
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
        setSelectedGoal={setSelectedGoal}
        setModalEditVisible={setModalEditVisible}
      />

        {modalVisible && (
          <ModalNewGoal
            setVisible={setModalVisible}
            cadastrar={cadastrar}
          />
        )}

        {modalEditVisible && selectedGoal && (
          <ModalEditGoal
            setVisible={setModalEditVisible}
            editar={editar}
            goal={selectedGoal}
            excluir={excluir}
          />
        )}
    </MainTemplate>
  );
}