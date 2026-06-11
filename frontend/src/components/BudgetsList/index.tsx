import { Pencil } from 'lucide-react';
import style from './style.module.css';
import type { Budget } from '../../types/Budget';
import { formatToReal } from '../../utils/formatToReal';

type BudgetsListProps = {
  budgets: Budget[],
  setBudget: React.Dispatch<React.SetStateAction<Budget | undefined>>
  setModalVisible: React.Dispatch<React.SetStateAction<boolean>>
}

export function BudgetsList({ budgets, setBudget, setModalVisible }: BudgetsListProps) {

  const get = () => {

    return budgets.map((budget, index) => {

      const percentage = budget.bdt_percentage ? budget.bdt_percentage / 100 : 0;

      return (
        <div className={style.card} key={index}>
          <div className={style.headerCard}>

            <h2 className={style.headerTitle}>{budget.bdt_name}</h2>

            <div className={style.cardValues}>
              <div>
                <span className={style.headerSubTitle}>{formatToReal(budget.bdt_amount_spent ?? '')} / {formatToReal(budget.bdt_limit.toString())}</span>
              </div>
              <button className={style.buttonEdit} onClick={() => {
                setBudget(budget);
                setModalVisible(true);
              }}>
                <Pencil /> Editar
              </button>
            </div>
          </div>

          <progress className={`${style.progressBar} ${style['background-' + budget.bdt_color.toLowerCase()]}`} value={percentage} />

          <div className={style.footerCard}>
            <span className={style.headerSubTitle}>Restam {formatToReal(budget.bdt_remaining_value ?? '')}</span>
            <span className={`${style.percentage} ${style[budget.bdt_color.toLowerCase()]}`}>{budget.bdt_percentage}%</span>
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