import { ButtonVisibleData } from '../../components/ButtonVisibleData';
import { DateSelector } from '../../components/DateSelector';
import { Heading } from '../../components/Heading';
import { Sidebar } from '../../components/Sidebar';
import style from './style.module.css';

type MainTemplate = {
  children: React.ReactNode,
  title: string,
  displayDate?: boolean
}

export function MainTemplate({ children, title, displayDate = true }: MainTemplate) {

  return (
    <>
      <div className={style.page}>
        <Sidebar />
        <div className={style.body}>
          <header className={style.header}>
            <div className={style.heading}>
              <Heading text={title} />
              {displayDate && <DateSelector />}
            </div>
            <ButtonVisibleData />
          </header>
          {children}
        </div>
      </div>
    </>
  );
}