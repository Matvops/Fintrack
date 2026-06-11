import { Check, X } from "lucide-react";
import { Heading } from "../../../components/Heading";
import { InputDefault } from "../../../components/InputDefault";
import style from './style.module.css';
import { useContext, useEffect, useState } from "react";
import { budget } from "../../../services/budget";
import { message } from "../../../adapters/message";
import { UserContext } from "../../../contexts/UserContext";
import { maskDate } from "../../../utils/maskDate";
import { formatToReal } from "../../../utils/formatToReal";
import type { Budget } from "../../../types/Budget";
import { DropdownGeneric } from "../../../components/DropdownGeneric";
import type { TransactionType } from "../../../types/TransactionType";
import type { NewTransationData } from "..";

type ModalNewTransaction = {
  setVisible: React.Dispatch<React.SetStateAction<boolean>>,
  create: (data: NewTransationData, e: React.SubmitEvent<HTMLFormElement>) => void
};

type Category = {
  label: string,
  value: number,
};

export function ModalNewTransaction({ setVisible, create }: ModalNewTransaction) {

  const { user } = useContext(UserContext);
  const [typeForm, setTypeForm] = useState<TransactionType>('expense')
  const [budgets, setBudgets] = useState<Budget[]>([]);
  const [categories, setCategories] = useState<Category[]>([]);
  const [category, setCategory] = useState<Category>();
  const [date, setDate] = useState('');
  const [value, setValue] = useState('');
  const [description, setDescription] = useState('');

  function getBudgets() {

    const response = budget.get(user.id);

    message.dismiss();

    response.then(data => {
      if (data.status) {
        setBudgets(data.data);
      } else {
        message.error(data.message);
      }
    })
  }

  useEffect(() => {
    getBudgets();
  }, [])

  useEffect(() => {

    budgets.map(budget => {

      setCategories(prevState => {

        const newBudget = { label: budget.bdt_name, value: budget.bdt_id };
        if (prevState.find(prev => prev.value === newBudget.value) && prevState.length > 0) return [...prevState];

        return [
          ...prevState,
          newBudget
        ];
      })

    })

  }, [budgets])

  return (
    <div className={style.modalBackground}>
      <div className={style.modal}>
        <div className={style.heading}>
          <Heading text='Nova transação' />

          <div className={style.closeIcon} onClick={() => setVisible(prevState => !prevState)}>
            <X />
          </div>
        </div>

        <div className={style.selectForm}>
          <div className={`${typeForm === 'expense' ? style.activeExpense : ''} ${style.selectTitleContainer}`} onClick={() => setTypeForm('expense')}>
            <button type='button' className={`${style.selectTitle} ${typeForm === 'expense' ? style.textActive : ''}`} >Despesa</button>
          </div>

          <div className={`${typeForm === 'income' ? style.activeIncome : ''} ${style.selectTitleContainer}`} onClick={() => setTypeForm('income')}>
            <button type='button' className={`${style.selectTitle} ${typeForm === 'income' ? style.textActive : ''}`} >Receita</button>
          </div>
        </div>


        <form className={style.form} onSubmit={(e) => create({category: category?.value, id: user.id, date: date, type: typeForm, description: description, value: value}, e)}>

          <InputDefault
            label='DESCRIÇÃO'
            placeholder='Ex: Conta de luz'
            type='text'
            onChange={e => setDescription(e.target.value)}
            value={description}
          />

          {typeForm === 'expense' && (
            <div className={style.dropdown}>
              <DropdownGeneric
                values={categories}
                selectedValue={category}
                setSelectedValue={setCategory}
                name="categories"
                title="Categorias"
                defaultLabel='Selecione uma categoria'
              />
            </div>
          )}

          <div className={style.saldos}>
            <InputDefault
              label='VALOR (R$)'
              placeholder='0'
              type='text'
              onChange={e => setValue(formatToReal(e.target.value))}
              value={value}
            />

            <InputDefault
              label='DATA (AAAA-MM-DD)'
              type='text'
              placeholder="2026-02-02"
              onChange={e => setDate(maskDate(e.target.value))}
              value={date}
            />
          </div>

          <div>
            <button className={style.buttonHeaderSection}><Check /> Salvar</button>
          </div>
        </form>


      </div>
    </div>
  );
}