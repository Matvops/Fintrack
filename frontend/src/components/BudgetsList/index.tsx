import { Pencil } from 'lucide-react';
import style from './style.module.css';
import type { Budget } from '../../types/Budget';
import { useFormatToReal } from '../../hooks/useDisplayValues';

type BudgetsListProps = {
  budgets: Budget[],
  setBudget: React.Dispatch<React.SetStateAction<Budget | undefined>>
  setModalVisible: React.Dispatch<React.SetStateAction<boolean>>
}

export function BudgetsList({ budgets, setBudget, setModalVisible }: BudgetsListProps) {

  const formatToReal = useFormatToReal();

  const get = () => {

    return budgets.map((budget, index) => {

      const percentage = budget.percentage ? budget.percentage / 100 : 0;

      return (
        <div className={style.card} key={index}>
          <div className={style.headerCard}>

            <h2 className={style.headerTitle}>{budget.name}</h2>

            <div className={style.cardValues}>
              <div>
                <span className={style.headerSubTitle}>{formatToReal(budget.amountSpent ?? '')} / {formatToReal(budget.limit.toString())}</span>
              </div>
              <button className={style.buttonEdit} onClick={() => {
                setBudget(budget);
                setModalVisible(true);
              }}>
                <Pencil /> Editar
              </button>
            </div>
          </div>

          <progress className={`${style.progressBar} ${style['background-' + budget.color.toLowerCase()]}`} value={percentage} />

          <div className={style.footerCard}>
            <span className={style.headerSubTitle}>{Number(budget.amountSpent) > Number(budget.limit) ? 'Excedeu ' : 'Restam '} 
              {formatToReal(budget.remainingValue ?? '')}
            </span>
            <span className={`${style.percentage} ${style[budget.color.toLowerCase()]}`}>{budget.percentage}%</span>
          </div>
        </div>
      )
    });

  };

  return (
    <main className={style.budgetsList}>
      {get()}
    </main>
  );
}