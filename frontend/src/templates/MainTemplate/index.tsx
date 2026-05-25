import { Sidebar } from '../../components/Sidebar';
import style from './style.module.css';

type MainTemplate = {
  children: React.ReactNode
}

export function MainTemplate({ children }: MainTemplate) {

  return (
    <>
      <div className={style.body}>
        <Sidebar />
        {children}
    </div>
    </>
  );
}