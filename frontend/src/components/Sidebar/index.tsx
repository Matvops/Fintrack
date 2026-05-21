import { CreditCard, LayoutDashboard, LogOut, Settings, Target, Wallet } from "lucide-react";
import { Logo } from "../Logo";
import style from './style.module.css';
import { useState } from "react";

type sections = 'Dashboard' | 'Transacoes' | 'Orcamento' | 'Metas' | 'Configuracoes';


export function Sidebar() {

  const [activeSection, setActiveSection] = useState<sections>('Dashboard');

  return (
    <div className={style.sidebar}>
        <Logo size='medium' />

        <nav className={style.sections}>
          <p 
            className={`${style.section} ${activeSection === 'Dashboard' ? style.activeSection: ''}`} 
            onClick={() => setActiveSection('Dashboard')}
          >
            <LayoutDashboard />Dashboard
          </p>
          <p 
            className={`${style.section} ${activeSection === 'Transacoes' ? style.activeSection: ''}`} 
            onClick={() => setActiveSection('Transacoes')}
          >
            <CreditCard />Transações
          </p>
          <p 
            className={`${style.section} ${activeSection === 'Orcamento' ? style.activeSection: ''}`} 
            onClick={() => setActiveSection('Orcamento')}
          >
            <Wallet />Orçamento
          </p>
          <p 
            className={`${style.section} ${activeSection === 'Metas' ? style.activeSection: ''}`} 
            onClick={() => setActiveSection('Metas')}
          >
            <Target />Metas
          </p>
          <p 
            className={`${style.section} ${activeSection === 'Configuracoes' ? style.activeSection: ''}`} 
            onClick={() => setActiveSection('Configuracoes')}
          >
            <Settings />Configurações
          </p>
        </nav>

        <div className={style.logoutContainer}>
          <p className={style.logout}>
            <LogOut /> Sair
          </p>
        </div>
      </div>
  );
}