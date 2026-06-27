import { ArrowDownRight, ArrowUpRight, PlusIcon } from "lucide-react";
import { MainTemplate } from "../../templates/MainTemplate";
import style from './style.module.css';
import { useContext, useEffect, useState } from "react";
import { ModalNewTransaction } from "./ModalNewTransaction";
import type { TransactionType } from "../../types/TransactionType";
import { message } from "../../adapters/message";
import { transaction } from "../../services/transaction";
import { UserContext } from "../../contexts/UserContext";
import type { Transaction } from "../../types/Transaction";
import { DateContext } from "../../contexts/DateContext";
import { useFormatToReal } from "../../hooks/useDisplayValues";

export type NewTransationData = {
  id: number | null,
  type: TransactionType,
  value: string,
  date: string,
  category: number | undefined,
  description: string
}


export function Transactions() {

  const { user } = useContext(UserContext);
  const { date } = useContext(DateContext);

  const formatToReal = useFormatToReal();
  

  const [modalVisible, setModalVisible] = useState(false);
  const [transactions, setTransactions] = useState<Transaction[]>([]);

  async function create(data: NewTransationData, e: React.SubmitEvent<HTMLFormElement>) {
    e.preventDefault();

    const response = await transaction.create(data);

    if (response.status) {
      message.success(response.message);
      setModalVisible(false);
      getTransactions();
      return;
    }

    message.error(response.message);
  }


  function getTransactions() {
    try {

      if (user.id === null) throw Error('ID inválido');

      const dateSelected = new Date(date.date);

      const response = transaction.get(user.id, dateSelected.getTime());

      message.dismiss();

      response.then(data => {
        if (data.message) {
          message.success(data.message);
          setTransactions(data.data);
        } else {
          message.error(data.message);
        }
      })
    } catch (err) {
      message.error('Erro ao consultar transações');
    }
  }

  useEffect(() => {
    document.title = 'Transactions';
  }, []);

  useEffect(() => {
     getTransactions(); 
  }, [date])

  const getList = () => {

    return transactions?.map((tx, index) => {

      const isExpense = tx.tra_type.toLowerCase() === 'expense';

      return (
        <div className={style.transaction} key={index}>
          <div className={style.transactionInfo}>
            {isExpense ? (
              <div className={style.arrowExpense}>
                <ArrowDownRight />
              </div>
            ) : (
              <div className={style.arrowIncome}>
                <ArrowUpRight />
              </div>
            )}
            <div>
              <p className={style.title}>{tx.tra_description}</p>
              <span className={style.info}>{tx.budget?.bdt_name ? `${tx.budget?.bdt_name} · ` : ``}{tx.tra_date}</span>
            </div>
          </div>
          <span className={isExpense ? style.valueExpense : style.valueIncome}>{isExpense && '-'} {formatToReal(tx.tra_value)}</span>
        </div>
      )
    })
  }

  return (
    <MainTemplate title="Transações">
        <main className={style.transactionsList}>
          <header className={style.headerList}>
            <h3>{transactions.length} lançamentos</h3>

            <div onClick={() => setModalVisible(true)}>
              <button className={style.buttonHeaderSection}><PlusIcon /> Nova</button>
            </div>
          </header>

          <section className={style.list}>
            {getList()}
          </section>
        </main>

        {modalVisible &&
          <ModalNewTransaction
            setVisible={setModalVisible}
            create={create}
          />}
    </MainTemplate>
  )
}