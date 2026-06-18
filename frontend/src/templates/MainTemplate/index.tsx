import { ButtonVisibleData } from '../../components/ButtonVisibleData';
import { Heading } from '../../components/Heading';
import { Sidebar } from '../../components/Sidebar';
import style from './style.module.css';

type MainTemplate = {
  children: React.ReactNode,
  title: string
}

export function MainTemplate({ children, title }: MainTemplate) {

  return (
    <>
      <div className={style.page}>
        <Sidebar />
        <div className={style.body}>
          <header className={style.header}>
            <Heading text={title} />
            <ButtonVisibleData />
          </header>
          {children}
        </div>
      </div>
    </>
  );
}