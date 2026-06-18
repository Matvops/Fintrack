import { ArrowLeft, ArrowRight } from 'lucide-react';
import style from './style.module.css';
import { useContext } from 'react';
import { DateContext } from '../../contexts/DateContext';

export function DateSelector() {

  const { date, setDate } = useContext(DateContext);

  function alterMonth(action: 'previous' | 'next') {
    const dateObj = new Date(date.date);

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
      <button type='button' className={style.button} onClick={() => alterMonth('next')}>
        <ArrowRight />
      </button>
    </div>
  );
}