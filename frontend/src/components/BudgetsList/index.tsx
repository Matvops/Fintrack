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

    return budgets.map((budget, index) => (
      <div className={style.card} key={index}>
        <div className={style.headerCard}>

          <h2 className={style.headerTitle}>{budget.bdt_name}</h2>

          <div className={style.cardValues}>
            <div>
              <span className={style.headerSubTitle}>R$ 515,00 / {formatToReal(budget.bdt_limit.toString())}</span>
            </div>
            <button className={style.buttonEdit} onClick={() => {
              setBudget(budget);
              setModalVisible(true);
            }}>
              <Pencil /> Editar
            </button>
          </div>
        </div>

        <progress className={`${style.progressBar} ${style['background-' + budget.bdt_color.toLowerCase()]}`} value={0.74} />

        <div className={style.footerCard}>
          <span className={style.headerSubTitle}>Restam R$ 185,00</span>
          <span className={`${style.percentage} ${style[budget.bdt_color.toLowerCase()]}`}>74%</span>
        </div>
      </div>
    ));

  };

  return (
    <main className={style.budgetsList}>
      {get()}
    </main>
  );
}