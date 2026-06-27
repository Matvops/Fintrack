import { CreditCard, LayoutDashboard, LogOutIcon, Settings, Target, Wallet } from "lucide-react";
import { Logo } from "../Logo";
import style from './style.module.css';
import { useLocation, useNavigate } from "react-router-dom";
import { useContext } from "react";
import { UserContext } from "../../contexts/UserContext";
import { auth } from "../../services/auth";
import { initialState } from "../../contexts/initialState";

type sections = 'home' | 'transactions' | 'budgets' | 'goals' | 'settings';


export function Sidebar() {

  const { user, setUser } = useContext(UserContext);
  const navigation = useNavigate();
  const locate = useLocation();
  const page = locate.pathname.split('/')[1];


  const colors = {
    ambar: style.ambar,
    rosa: style.rosa,
    azul: style.azul,
    esmeralda: style.esmeralda,
    violeta: style.violeta,
  };

  function setPage(activeSection: sections) {
    navigation(`/${activeSection}`);
  }

  async function LogOut() {

    const payload = {
      id: user.id
    };

    await auth.logOut(payload);
    setUser(initialState);

    navigation('/');
  }

  return (
    <div className={style.sidebar}>
      <Logo size='medium' />

      <nav className={style.sections}>
        <p
          className={`${style.section} ${page === 'home' ? `${style.activeSection} ${colors[user.mainColor]}` : ''}`}
          onClick={() => setPage('home')}
        >
          <LayoutDashboard />Dashboard
        </p>
        <p
          className={`${style.section} ${page === 'transactions' ? `${style.activeSection} ${colors[user.mainColor]}` : ''}`}
          onClick={() => setPage('transactions')}
        >
          <CreditCard />Transações
        </p>
        <p
          className={`${style.section} ${page === 'budgets' ? `${style.activeSection} ${colors[user.mainColor]}` : ''}`}
          onClick={() => setPage('budgets')}
        >
          <Wallet />Orçamento
        </p>
        <p
          className={`${style.section} ${page === 'goals' ? `${style.activeSection} ${colors[user.mainColor]}` : ''}`}
          onClick={() => setPage('goals')}
        >
          <Target />Metas
        </p>
        <p
          className={`${style.section} ${page === 'settings' ? `${style.activeSection} ${colors[user.mainColor]}` : ''}`}
          onClick={() => setPage('settings')}
        >
          <Settings />Configurações
        </p>
      </nav>

      <div className={style.logoutContainer}>
        <div onClick={() => LogOut()} className={style.logout}>
          <LogOutIcon /> Sair
        </div>
      </div>
    </div>
  );
}