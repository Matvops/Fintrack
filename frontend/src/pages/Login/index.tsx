import { TrendingUp } from 'lucide-react';
import { Container } from '../../components/Container';
import style from './style.module.css';
import { useState } from 'react';
import { FormLogin } from '../../components/FormLogin';
import { FormCadastro } from '../../components/FormCadastro';
import { Logo } from '../../components/Logo';

export function Login() {

  const [typeForm, setTypeForm] = useState<'Entrar' | 'Cadastrar'>('Entrar')

  return (
    <Container>
      <div className={style.container}>

        <div className={style.modal}>

          <div className={style.header}>
            <div className={style.containerIcon}>
              <TrendingUp />
            </div>

            <Logo size='big' />

            <p className={style.description}>Controle financeiro pessoal</p>
          </div>

          <div className={style.selectForm}>
            <div className={`${typeForm === 'Entrar' ? style.active : ''} ${style.selectTitleContainer}`} onClick={() => setTypeForm('Entrar')}>
              <button type='button' className={`${style.selectTitle} ${typeForm === 'Entrar' ? style.textActive : ''}`} >Entrar</button>
            </div>
            
            <div className={`${typeForm === 'Cadastrar' ? style.active : ''} ${style.selectTitleContainer}`} onClick={() => setTypeForm('Cadastrar')}>
              <button type='button' className={`${style.selectTitle} ${typeForm === 'Cadastrar' ? style.textActive : ''}`} >Cadastrar</button>
            </div>
          </div>

          {typeForm === 'Entrar' ? <FormLogin /> : <FormCadastro />}

        </div>

      </div>
    </Container>
  )
}