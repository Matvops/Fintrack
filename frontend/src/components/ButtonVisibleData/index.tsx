import { EyeIcon, EyeOffIcon } from 'lucide-react';
import style from './style.module.css';
import { useContext } from 'react';
import { UserContext } from '../../contexts/UserContext';

export function ButtonVisibleData() {

  const { user, setUser } = useContext(UserContext);

  function alterVisible() {
    setUser(prevState => {

      return {
        ...prevState,
        hiddenData: !prevState.hiddenData
      }
    })
  }

  return (
    <button className={style.button} onClick={alterVisible}>
      {user.hiddenData ? <EyeOffIcon /> : <EyeIcon />}
    </button>
  )
}