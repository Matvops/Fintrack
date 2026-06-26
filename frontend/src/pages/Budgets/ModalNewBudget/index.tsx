
import { Check, X } from 'lucide-react';
import { Heading } from '../../../components/Heading';
import style from './style.module.css';
import { InputDefault } from '../../../components/InputDefault';
import { useContext, useState } from 'react';
import { Colors } from '../../../components/Colors';
import type { MainColor } from '../../../types/MainColor';
import { UserContext } from '../../../contexts/UserContext';
import type { NewBudgetData } from '..';
import { useFormatToReal } from '../../../hooks/useDisplayValues';

type ModalNewBudgetProps = {
  setVisible: React.Dispatch<React.SetStateAction<boolean>>,
  create: (data: NewBudgetData, event: React.SubmitEvent<HTMLFormElement>) => void
}

export function ModalNewBudget({ setVisible, create }: ModalNewBudgetProps) {

  const formatToReal = useFormatToReal();

  const [name, setName] = useState('');
  const [limit, setLimit] = useState('');
  const [color, setColor] = useState<MainColor>('ambar');
  const { user } = useContext(UserContext);
  const [id] = useState(user.id);


  return (
    <div className={style.modalBackground}>
      <div className={style.modal}>
        <div className={style.heading}>
          <Heading text='Novo orçamento' />

          <div className={style.closeIcon} onClick={() => setVisible(prevState => !prevState)}>
            <X />
          </div>
        </div>

        <form className={style.form} onSubmit={(e) => create({id: id, name: name, limit: limit, color: color}, e)}>

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
            value={limit}
          />

          <div>
            <h2 className={style.headerColor}>COR</h2>
            <Colors
              color={color}
              setColor={setColor}
            />
          </div>

          <div>
            <button className={style.buttonHeaderSection}><Check /> Salvar</button>
          </div>
        </form>


      </div>
    </div>
  );
}