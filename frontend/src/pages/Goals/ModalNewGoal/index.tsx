
import { Check, X } from 'lucide-react';
import { Heading } from '../../../components/Heading';
import style from './style.module.css';
import { InputDefault } from '../../../components/InputDefault';
import { useContext, useState } from 'react';
import { Colors } from '../../../components/Colors';
import type { MainColor } from '../../../types/MainColor';
import type { NewGoalData } from '..';
import { UserContext } from '../../../contexts/UserContext';

type ModalNewGoalProps = {
  setVisible: React.Dispatch<React.SetStateAction<boolean>>,
  cadastrar: (data: NewGoalData, event: React.SubmitEvent<HTMLFormElement>) => void
}

export function ModalNewGoal({ setVisible, cadastrar }: ModalNewGoalProps) {

  const [name, setName] = useState('');
  const [balance, setBalance] = useState('');
  const [balanceTarget, setBalanceTarget] = useState('');
  const [color, setColor] = useState<MainColor>('ambar');
  const { user } = useContext(UserContext);
  const [id] = useState(user.id);
  

  const formatarParaReal = (valor: string): string => {
    // Remove tudo que não for dígito
    const apenasNumeros = valor.replace(/\D/g, '');

    // Transforma em centavos (ex: "150" vira 1.50)
    const valorNumerico = Number(apenasNumeros) / 100;

    // Formata usando o Intl
    return new Intl.NumberFormat('pt-BR', {
      style: 'currency',
      currency: 'BRL',
    }).format(valorNumerico);
  };

  return (
    <div className={style.modalBackground}>
      <div className={style.modal}>
        <div className={style.heading}>
          <Heading text='Nova Meta' />

          <div className={style.closeIcon} onClick={() => setVisible(prevState => !prevState)}>
            <X />
          </div>
        </div>

        <form className={style.form} onSubmit={(e) => cadastrar({id, name, balance, balanceTarget, color}, e)}>

          <InputDefault
            label='NOME DA META'
            placeholder='Ex: Viagem p/ Europa'
            type='text'
            onChange={e => setName(e.target.value)}
            value={name}
          />

          <div className={style.saldos}>
            <InputDefault
              label='VALOR ATUAL (R$)'
              placeholder='0'
              type='text'
              onChange={e => setBalance(formatarParaReal(e.target.value))}
              value={balance}
            />

            <InputDefault
              label='OBJETIVO (R$)'
              placeholder='0'
              type='text'
              onChange={e => setBalanceTarget(formatarParaReal(e.target.value))}
              value={balanceTarget}
            />
          </div>

          <div className={style.colors}>
            <h2 className={style.headerColor}>COR</h2>
            <Colors
              color={color}
              setColor={setColor}
            />
          </div>

          <div>
            <button className={style.buttonHeaderSection}><Check /> Nova meta</button>
          </div>
        </form>


      </div>
    </div>
  );
}