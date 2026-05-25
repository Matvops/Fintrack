import { CreditCard, LayoutDashboard, LogOut, Settings, Target, Wallet } from "lucide-react";
import { Logo } from "../Logo";
import style from './style.module.css';
import { Link, useLocation, useNavigate } from "react-router-dom";

type sections = 'home' | 'transactions' | 'orcamento' | 'goals' | 'settings';


export function Sidebar() {

  const navigation = useNavigate();
  const locate = useLocation();
  const page = locate.pathname.split('/')[1];

  function setPage(activeSection: sections) {
    navigation(`/${activeSection}`);
  }

  return (
    <div className={style.sidebar}>
      <Logo size='medium' />

      <nav className={style.sections}>
        <p
          className={`${style.section} ${page === 'home' ? style.activeSection : ''}`}
          onClick={() => setPage('home')}
        >
          <LayoutDashboard />Dashboard
        </p>
        <p
          className={`${style.section} ${page === 'transactions' ? style.activeSection : ''}`}
          onClick={() => setPage('transactions')}
        >
          <CreditCard />Transações
        </p>
        <p
          className={`${style.section} ${page === 'orcamentos' ? style.activeSection : ''}`}
          onClick={() => setPage('orcamento')}
        >
          <Wallet />Orçamento
        </p>
        <p
          className={`${style.section} ${page === 'goals' ? style.activeSection : ''}`}
          onClick={() => setPage('goals')}
        >
          <Target />Metas
        </p>
        <p
          className={`${style.section} ${page === 'settings' ? style.activeSection : ''}`}
          onClick={() => setPage('settings')}
        >
          <Settings />Configurações
        </p>
      </nav>

      <div className={style.logoutContainer}>
        <Link to={'/'} className={style.logout}>
          <LogOut /> Sair
        </Link>
      </div>
    </div>
  );
}