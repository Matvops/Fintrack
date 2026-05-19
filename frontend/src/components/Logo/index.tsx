import style from './style.module.css';

type LogoProps = {
  size: 'small' | 'medium' | 'big'
}

export function Logo({ size }: LogoProps) {

  const sizes = {
    small: 'largel',
    medium: 'x-large',
    big: 'xx-large',
  }

  return (
    <h1 style={{fontSize: sizes[size]}} className={style.title}>Fin<span>track</span></h1>
  );
}