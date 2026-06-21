import { ArrowLeft, ArrowRight } from 'lucide-react';
import style from './style.module.css';
import { useContext } from 'react';
import { DateContext } from '../../contexts/DateContext';

export function DateSelector() {

  const { date, setDate } = useContext(DateContext);
  const dateObj = new Date(date.date);
  const actualDate = new Date();

  function alterMonth(action: 'previous' | 'next') {

    if(dateObj.toLocaleDateString() == actualDate.toLocaleDateString() && action === 'next') return;

    if(action === 'next') {
      dateObj.setMonth(dateObj.getMonth() + 1);
    } else {
      dateObj.setMonth(dateObj.getMonth() - 1);
    }

    const mes = dateObj.toLocaleDateString('pt-BR', { month: 'long' });
    const ano = dateObj.toLocaleDateString('pt-BR', { year: 'numeric' });

    setDate({
      date: dateObj.getTime(),
      formattedDate: mes.charAt(0).toUpperCase() + mes.slice(1) + ' ' + ano
    });

  }
  return (
    <div className={style.date}>
      <button type='button' className={style.button} onClick={() => alterMonth('previous')}>
        <ArrowLeft />
      </button>
      <span className={style.month}>{date.formattedDate}</span>
      <button type='button' className={style.button} onClick={() => alterMonth('next')} disabled={dateObj.toLocaleDateString() == actualDate.toLocaleDateString()}>
        <ArrowRight />
      </button>
    </div>
  );
}