import { ButtonDefault } from "../ButtonDefault";
import { InputDefault } from "../InputDefault";
import style from './style.module.css';

export function FormLogin() {

  return (
    <form className={style.form}>

      <div>
        <InputDefault
          label='E-MAIL'
          placeholder='example@gmail.com'
          type='email'
        />
      </div>

      <div>
        <InputDefault
          label='Senha'
          placeholder='admin123'
          type='password'
          autoComplete='off'
        />
      </div>

      <div className={style.containerButton}>
        <ButtonDefault
          text='Entrar'
        />
      </div>

    </form>
  );
}