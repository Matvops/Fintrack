import { useNavigate } from "react-router-dom";
import { ButtonDefault } from "../ButtonDefault";
import { InputDefault } from "../InputDefault";
import style from './style.module.css';
import { auth } from "../../services/auth";
import { useState } from "react";
import { message } from "../../adapters/message";

export function FormLogin() {
  const navigate = useNavigate();

  const [email, setEmail] = useState<string | null>(null);
  const [password, setPassword] = useState<string | null>(null);

  async function login(e: React.MouseEvent<HTMLButtonElement, MouseEvent>) {
    e.preventDefault();

    const json = {
      email: email,
      password: password,
    }

    const response = await auth.login(json);

    console.log(response);
    if (response.status) {
      message.success(response.message)
      navigate('/home');
    } else {
      message.error(response.message)
    }
  }

  return (
    <form className={style.form}>

      <div>
        <InputDefault
          label='E-MAIL'
          placeholder='example@gmail.com'
          type='email'
          value={email ?? ''}
          onChange={e => setEmail(e.target.value)}
        />
      </div>

      <div>
        <InputDefault
          label='Senha'
          placeholder='admin123'
          type='password'
          autoComplete='off'
          value={password ?? ''}
          onChange={e => setPassword(e.target.value)}
        />
      </div>

      <div className={style.containerButton}>
        <ButtonDefault
          text='Entrar'
          onClick={e => login(e)}
        />
      </div>

    </form>
  );
}