import { Pencil } from 'lucide-react';
import style from './style.module.css';
import type { Goal } from '../../types/Goal';
import { formatToReal } from '../../utils/formatToReal';

type GoalsListProps = {
  goals: Goal[] | []
}

export function GoalsList({ goals }: GoalsListProps) {

  const getCards = () => {

    if(goals.length === 0) return;
    
    return goals.map((goal, index) => (
      <div className={style.card} key={goal.gls_id + `-${index}`}>
        <div className={style.headerCard}>

          <div>
            <h2 className={style.headerTitle}>{goal.gls_name}</h2>
            <span className={style.headerSubTitle}>{goal.percentage}% concluído</span>
          </div>

          <div className={style.cardValues}>
            <div>
              <h2 className={`${style.headerTitle} ${style[goal.gls_color.toLowerCase()]}`}>{formatToReal(goal.gls_balance)}</h2>
              <span className={style.headerSubTitle}>de {formatToReal(goal.gls_balance_target)}</span>
            </div>
            <button className={style.buttonEdit}>
              <Pencil /> Editar
            </button>
          </div>
        </div>

        <progress className={`${style.progressBar} ${style['background-' + goal.gls_color.toLocaleLowerCase()]}`} value={(goal.percentage ?? 0) / 100} />

        <div>
          <span className={style.headerSubTitle}>Faltam {formatToReal(goal.missing?.toString() ?? '0')} para a meta</span>
        </div>
      </div>
    ));

  }

  return (
    <main className={style.goalsList}>
      {getCards()}
    </main>
  );
}