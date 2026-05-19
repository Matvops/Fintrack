import { useNavigate } from 'react-router-dom';
import { ButtonDefault } from '../ButtonDefault';
import { InputDefault } from '../InputDefault';
import style from './style.module.css';

export function FormCadastro() {
  const navigate = useNavigate();


  function cadastrar(e: React.MouseEvent<HTMLButtonElement, MouseEvent>) {
    e.preventDefault();
    navigate('/home');
  }

  return (
    <form className={style.form}>

      <div>
        <InputDefault
          label='NOME COMPLETO'
          placeholder='José Da Silva'
          type='text'
        />
      </div>

      <div>
        <InputDefault
          label='E-MAIL'
          placeholder='email@example.com'
          type='email'
        />
      </div>

      <div className={style.containerPassword}>
        <InputDefault
          label='Senha'
          placeholder='admin123'
          type='password'
          autoComplete='off'
        />

         <InputDefault
          label='Confirme a senha'
          placeholder='admin123'
          type='password'
          autoComplete='off'
        />
      </div>

      <div className={style.containerButton}>
        <ButtonDefault
          text='Cadastrar'
          onClick={e => cadastrar(e)}
        />
      </div>

    </form>
  );
}