import type React from 'react';
import style from './style.module.css';
import { useContext } from 'react';
import { UserContext } from '../../contexts/UserContext';


type ButtonTextIconProps = {
  text: string,
  icon: React.ReactNode
}

export function ButtonTextIcon({ text, icon }: ButtonTextIconProps) {

  const { user } = useContext(UserContext);

  const colors = {
    ambar: style.ambar,
    rosa: style.rosa,
    azul: style.azul,
    esmeralda: style.esmeralda,
    violeta: style.violeta,
  };

  return (
    <>
      <button className={`${style.button} ${colors[user.mainColor]}`}>{icon} {text}</button>
    </>
  );
}