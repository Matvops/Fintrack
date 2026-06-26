
import { Check, Trash, X } from 'lucide-react';
import { Heading } from '../../../components/Heading';
import style from './style.module.css';
import { InputDefault } from '../../../components/InputDefault';
import { useState } from 'react';
import { Colors } from '../../../components/Colors';
import type { MainColor } from '../../../types/MainColor';
import type { Goal } from '../../../types/Goal';
import { useFormatToReal } from '../../../hooks/useDisplayValues';

type ModalEditGoalProps = {
  setVisible: React.Dispatch<React.SetStateAction<boolean>>,
  editar: (data: Goal, event: React.SubmitEvent<HTMLFormElement>) => void,
  excluir: (id: number, event: React.MouseEvent<HTMLButtonElement, MouseEvent>) => void,
  goal: Goal
}

export function ModalEditGoal({ setVisible, editar, excluir, goal }: ModalEditGoalProps) {

    
  const formatToReal = useFormatToReal();

  const [name, setName] = useState(goal.gls_name ?? '');
  const [balance, setBalance] = useState(formatToReal(goal.gls_balance ?? '0'));
  const [balanceTarget, setBalanceTarget] = useState(formatToReal(goal.gls_balance_target ?? ''));
  const [color, setColor] = useState<MainColor>(() => {


    const color = goal?.gls_color.toLowerCase();
    if (color !== 'ambar' && color !== 'rosa' && color !== 'violeta' && color !== 'esmeralda' && color !== 'azul') {
      return 'ambar'
    }

    return color;

  });

  return (
    <div className={style.modalBackground}>
      <div className={style.modal}>
        <div className={style.heading}>
          <Heading text='Editar Meta' />

          <div className={style.closeIcon} onClick={() => setVisible(prevState => !prevState)}>
            <X />
          </div>
        </div>

        <form className={style.form} onSubmit={(e) => editar({
          gls_id: goal.gls_id,
          gls_balance: balance,
          gls_balance_target: balanceTarget,
          gls_name: name,
          gls_color: color,
        }, e)}>

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
              onChange={e => setBalance(formatToReal(e.target.value))}
              value={formatToReal(balance)}
            />

            <InputDefault
              label='OBJETIVO (R$)'
              placeholder='0'
              type='text'
              onChange={e => setBalanceTarget(formatToReal(e.target.value))}
              value={formatToReal(balanceTarget)}
            />
          </div>

          <div className={style.colors}>
            <h2 className={style.headerColor}>COR</h2>
            <Colors
              color={color}
              setColor={setColor}
            />
          </div>

          <div className={style.buttons}>
            <button type='button' className={`${style.buttonHeaderSection} ${style.buttonCancel}`} onClick={(e) => excluir(goal.gls_id, e)}
            >
              <Trash /> Excluir
            </button>
            <button className={`${style.buttonHeaderSection} ${style.buttonSave}`}><Check /> Salvar</button>
          </div>
        </form>


      </div>
    </div>
  );
}