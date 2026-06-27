import style from './style.module.css';
import { MainTemplate } from '../../templates/MainTemplate';
import { ArrowDownRight, ArrowUpRight, ChartLine } from 'lucide-react';
import { ChartLineArea } from './ChartLineArea';
import { useContext, useEffect, useState } from 'react';
import { dashboard } from '../../services/dashboard';
import { message } from '../../adapters/message';
import { UserContext } from '../../contexts/UserContext';
import type { Dashboard } from '../../types/Dashboard';
import { ChartPie } from './ChartPie';
import { DateContext } from '../../contexts/DateContext';
import { CardHome } from '../../components/CardHome';

export function Home() {

  const colors = {
    ambar: style.ambar,
    rosa: style.rosa,
    azul: style.azul,
    esmeralda: style.esmeralda,
    violeta: style.violeta,
  };
  
  const { user } = useContext(UserContext);
  const { date } = useContext(DateContext);

  const [dashboardData, setDashboardData] = useState<Dashboard|null>(null);

  function getData() {

    const dateSelected = new Date(date.date);

    const response = dashboard.get(user.id, dateSelected.getTime());

    message.dismiss();

    response.then(data => {
      if (data.status) {
        message.success(data.message);
        setDashboardData(data.data);
      } else {
        message.error(data.message);
      }
    })
  }

  useEffect(() => {
    document.title = 'Dashboard'
  }, []);

  useEffect(() => {
    getData();
  }, [date]);

  return (
    <MainTemplate title='Dashboard'>
      <div className={style.body}>
        <section className={style.cards}>

          <CardHome
            title='Receitas'
            value={dashboardData?.income}
            icon={
              <div className={style.arrowUpIcon}>
                <ArrowUpRight />
              </div>
            }
          />

          <CardHome
            title='Despesas'
            value={dashboardData?.expense}
            icon={
              <div className={style.arrowDownIcon}>
                <ArrowDownRight />
              </div>
            }
          />

          <CardHome
            title='Saldos'
            value={dashboardData?.balance}
            icon={
              <div className={`${style.chartIcon} ${colors[user.mainColor]}`}>
                <ChartLine />
              </div>
            }
          />
        </section>

        <section className={style.charts}>
          <div className={style.cardChartLine}>
            <ChartLineArea
              data={[...dashboardData?.peerMonths || []].reverse()}
            />
          </div>

          {!!dashboardData?.peerBudgets.length && (
            <div className={style.cardPieChart}>
              <ChartPie
                values={dashboardData?.peerBudgets}
              />
            </div>
          )}
        </section>
      </div>
    </MainTemplate>
  );
}