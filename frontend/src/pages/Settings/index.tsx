import { useContext, useEffect, useState } from "react";
import { MainTemplate } from "../../templates/MainTemplate";
import style from './style.module.css';
import type { MainColor } from "../../types/MainColor";
import { Colors } from "../../components/Colors";
import { UserContext } from "../../contexts/UserContext";
import { auth } from "../../services/auth";
import { initialState } from "../../contexts/initialState";
import { useNavigate } from "react-router-dom";

export function Settings() {

  const { user, setUser } = useContext(UserContext);
  const [color, setColor] = useState<MainColor>(user.mainColor);
  const navigation = useNavigate();

  useEffect(() => {
    setUser(prevState => {
      return {
        ...prevState,
        mainColor: color
      }
    })
  }, [color]);


  async function logout() {
    await auth.logOut({id: user.id});

    setUser(initialState);
    navigation('/');
  }

  useEffect(() => {
    document.title = 'Settings';
  }, []);
  

  return (
    <MainTemplate title="Configurações" displayDate={false}>
        <main className={style.cards}>
          <section className={style.card}>
            <div className={style.colors}>
              <h1>Cor de destaque</h1>
              <Colors
                color={color}
                setColor={setColor}
              />
            </div>
          </section>

          <section className={style.card}>
            <div className={style.account}>
              <h1>Conta</h1>
              <div className={style.accountInfo}>
                <div className={style.info}>
                  <span className={style.label}>Nome</span>
                  <span className={style.value}>{user.name}</span>
                </div>
                <div className={style.info}>
                  <span className={style.label}>E-mail</span>
                  <span className={style.value}>{user.email}</span>
                </div>
                <div className={style.info}>
                  <span className={style.label}>Plano</span>
                  <span className={style.value}>{user.plan}</span>
                </div>
              </div>
            </div>
          </section>

          <section className={style.card}>
            <div className={style.session}>
              <h1>Sessão</h1>
              <button onClick={() => logout()} type="button" className={style.button}>Sair da conta</button>
            </div>
          </section>
        </main>
    </MainTemplate>
  );
}