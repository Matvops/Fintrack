import type { ComponentProps } from "react"
import style from './style.module.css';

type InputDefaultPropos = {
  label: string
} & ComponentProps<'input'>

export function InputDefault({ label, ...props }: InputDefaultPropos) {

  return (
    <>
     <div className={style.inputContainer}>
        <label htmlFor={label} className={style.label}>{label}</label>
        <input id={label} className={style.input} {...props} />
     </div>
    </>
  );
}