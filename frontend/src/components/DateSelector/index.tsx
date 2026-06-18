import { ArrowLeft, ArrowRight } from 'lucide-react';
import style from './style.module.css';

export function DateSelector() {

  return (
    <div className={style.date}>
      <button type='button' className={style.button}>
        <ArrowLeft />
      </button>
      <span className={style.month}>Junho 2026</span>
      <button type='button' className={style.button}>
        <ArrowRight />
      </button>
    </div>
  );
}