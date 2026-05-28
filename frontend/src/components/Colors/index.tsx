import type { MainColor } from '../../types/MainColor';
import style from './style.module.css';

type ColorsProps = {
  color: MainColor,
  setColor: React.Dispatch<React.SetStateAction<MainColor>>
}

export function Colors({ color, setColor }: ColorsProps) {

  return (
    <div className={style.colors}>
      <div className={`${style.color} ${style.ambar} ${ color === 'ambar' ? style.active : ''}`} onClick={() => setColor('ambar')}></div>
      <div className={`${style.color} ${style.violeta} ${ color === 'violeta' ? style.active : ''}`} onClick={() => setColor('violeta')}></div>
      <div className={`${style.color} ${style.esmeralda} ${ color === 'esmeralda' ? style.active : ''}`} onClick={() => setColor('esmeralda')}></div>
      <div className={`${style.color} ${style.rosa} ${ color === 'rosa' ? style.active : ''}`} onClick={() => setColor('rosa')}></div>
      <div className={`${style.color} ${style.azul} ${ color === 'azul' ? style.active : ''}`} onClick={() => setColor('azul')}></div>
    </div>
  );
}