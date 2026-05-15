import { TrendingUp } from 'lucide-react';
import { Container } from '../../components/Container';
import style from './style.module.css';
import { useState } from 'react';
import { InputDefault } from '../../components/InputDefault';
import { ButtonDefault } from '../../components/ButtonDefault';

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

            <h1 className={style.title}>Fin<span>track</span></h1>

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

          <form className={style.form}>
            
            <div>
              <InputDefault
                label='E-MAIL'
                placeholder='example@gmail.com'
              />
            </div>

            <div>
              <InputDefault
                label='Senha'
                placeholder='example'
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

        </div>

      </div>
    </Container>
  )
}