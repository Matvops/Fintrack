import type { ComponentProps } from 'react';
import style from './style.module.css';

type ButtonDefaultProps = {
 text: string,
 icon?: React.ReactNode,
} & ComponentProps<'button'>

export function ButtonDefault({text, icon, ...props}: ButtonDefaultProps) {

  return (
    <>
      <button type="button" className={style.button} {...props}>{icon ?? text}</button>
    </>
  );
}