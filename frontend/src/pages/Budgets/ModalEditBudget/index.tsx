
import { Check, Trash, X } from 'lucide-react';
import { Heading } from '../../../components/Heading';
import style from './style.module.css';
import { InputDefault } from '../../../components/InputDefault';
import { useState } from 'react';
import { Colors } from '../../../components/Colors';
import type { MainColor } from '../../../types/MainColor';
import { formatToReal } from '../../../utils/formatToReal';
import type { Budget } from '../../../types/Budget';

type ModalEditBudgetProps = {
  setVisible: React.Dispatch<React.SetStateAction<boolean>>,
  edit: (data: Budget, event: React.SubmitEvent<HTMLFormElement>) => void,
  excluir: (id: number, event: React.MouseEvent<HTMLButtonElement, MouseEvent>) => void,
  budget: Budget
}

export function ModalEditBudget({ setVisible, edit, excluir, budget }: ModalEditBudgetProps) {

  const [name, setName] = useState(budget.bdt_name ?? '');
  const [limit, setLimit] = useState(formatToReal(budget.bdt_limit.toString() ?? '0'));
  const [color, setColor] = useState<MainColor>(() => {

    const color = budget?.bdt_color.toLowerCase();
    if (color !== 'ambar' && color !== 'rosa' && color !== 'violeta' && color !== 'esmeralda' && color !== 'azul') {
      return 'ambar'
    }

    return color;

  });

  return (
    <div className={style.modalBackground}>
      <div className={style.modal}>
        <div className={style.heading}>
          <Heading text='Editar Orçamento' />

          <div className={style.closeIcon} onClick={() => setVisible(prevState => !prevState)}>
            <X />
          </div>
        </div>

        <form className={style.form} onSubmit={(e) => edit({
          bdt_id: budget.bdt_id,
          bdt_name: name,
          bdt_color: color,
          bdt_limit: limit
        }, e)}>

          <InputDefault
            label='CATEGORIA'
            placeholder='Ex: Alimentação'
            type='text'
            onChange={e => setName(e.target.value)}
            value={name}
          />

          <InputDefault
            label='LIMITE MENSAL (R$)'
            placeholder='0'
            type='text'
            onChange={e => setLimit(formatToReal(e.target.value))}
            value={formatToReal(limit)}
          />

          <div>
            <h2 className={style.headerColor}>COR</h2>
            <Colors
              color={color}
              setColor={setColor}
            />
          </div>

          <div className={style.buttons}>
            <button type='button' className={`${style.buttonHeaderSection} ${style.buttonCancel}`} onClick={(e) => excluir(budget.bdt_id, e)}
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