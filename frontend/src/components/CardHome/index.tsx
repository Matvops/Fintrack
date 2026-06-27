import style from './style.module.css';
import { useFormatToReal } from '../../hooks/useDisplayValues';
import type React from 'react';


type CardHomeProps = {
  title: string,
  icon: React.ReactNode,
  value?: string
}

export function CardHome({title, icon, value = ''}: CardHomeProps) {


  const formatToReal = useFormatToReal();

  return (
    <div className={style.card}>
      <div className={style.headerCard}>
        <span className={style.title}>{title}</span>
        {icon}
      </div>
      <h1>{value.includes('-') ? '-' + formatToReal(value) : formatToReal(value)}</h1>
    </div>
  )
}