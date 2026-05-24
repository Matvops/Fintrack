import { useNavigate } from 'react-router-dom';
import { ButtonDefault } from '../ButtonDefault';
import { InputDefault } from '../InputDefault';
import style from './style.module.css';
import { useState } from 'react';
import { auth } from '../../services/auth';
import { message } from '../../adapters/message';

export function FormCadastro() {
  const navigate = useNavigate();
  
  const [name, setName] = useState<string|null>(null);
  const [email, setEmail] = useState<string|null>(null);
  const [password, setPassword] = useState<string|null>(null);
  const [confirmationPassword, setConfirmationPassword] = useState<string|null>(null);

  const samePassword = password === confirmationPassword;

  async function cadastrar(e: React.MouseEvent<HTMLButtonElement, MouseEvent>) {
    e.preventDefault();

    const json = {
      name: name,
      email: email,
      password: password,
      confirmationPassword: confirmationPassword
    }

    const response = await auth.register(json);

    if(response.status) {
      message.success(response.message)
      navigate('/home');
    } else {
      message.error(response.message)
      reset();
    }
  }

  function reset() {
    setEmail(null);
    setPassword(null);
    setConfirmationPassword(null);
  }

  return (
    <form className={style.form}>

      <div>
        <InputDefault
          label='NOME COMPLETO'
          placeholder='José Da Silva'
          type='text'
          onChange={e => setName(e.target.value)}
          value={name ?? ''}
        />
      </div>

      <div>
        <InputDefault
          label='E-MAIL'
          placeholder='email@example.com'
          type='email'
          onChange={e => setEmail(e.target.value)}
          value={email ?? ''}
        />
      </div>

      <div className={style.containerPassword}>
        <InputDefault
          label='Senha'
          placeholder='admin123'
          type='password'
          autoComplete='off'
          onChange={e => setPassword(e.target.value)}
          style={samePassword ?  undefined : {borderWidth: 1, borderColor: 'red'}}
          value={password ?? ''}
        />

         <InputDefault
          label='Confirme a senha'
          placeholder='admin123'
          type='password'
          autoComplete='off'
          onChange={e => setConfirmationPassword(e.target.value)}
          style={samePassword ? undefined : {borderWidth: 1, borderColor: 'red'}}
          value={confirmationPassword ?? ''}
        />
      </div>
    
      <div className={style.containerButton}>
        <ButtonDefault
          text='Cadastrar'
          onClick={e => cadastrar(e)}
        />
      </div>

      {samePassword === false && (
        <span className={style.messageError}>As senhas precisam ser iguais</span>
      )}


    </form>
  );
}