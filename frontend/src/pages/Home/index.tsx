import style from './style.module.css';
import { Heading } from '../../components/Heading';
import { MainTemplate } from '../../templates/MainTemplate';
import { ButtonVisibleData } from '../../components/ButtonVisibleData';
import { ArrowDownRight, ArrowUpRight, ChartLine } from 'lucide-react';
import { ChartLineArea } from './ChartLineArea';
import { useContext, useEffect, useState } from 'react';
import { dashboard } from '../../services/dashboard';
import { message } from '../../adapters/message';
import { UserContext } from '../../contexts/UserContext';
import type { Dashboard } from '../../types/Dashboard';
import { formatToReal } from '../../utils/formatToReal';
import { ChartPie } from './ChartPie';

export function Home() {

  const { user } = useContext(UserContext);
  const [dashboardData, setDashboardData] = useState<Dashboard>();

  function getData() {
    const response = dashboard.get(user.id);

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
    getData();
  }, []);

  useEffect(() => {
    console.log(dashboardData);
  }, [dashboardData]);

  return (
    <MainTemplate>
      <div className={style.page}>
        <header className={style.header}>
          <Heading text='Dashboard' />

          <ButtonVisibleData />
        </header>

        <div className={style.body}>
          <section className={style.cards}>

            <div className={style.card}>
              <div className={style.headerCard}>
                <span className={style.title}>Receitas</span>
                <div className={style.arrowUpIcon}>
                  <ArrowUpRight />
                </div>
              </div>
              <h1>{formatToReal(dashboardData?.income ?? '')}</h1>
            </div>

            <div className={style.card}>
              <div className={style.headerCard}>
                <span className={style.title}>Despesas</span>
                <div className={style.arrowDownIcon}>
                  <ArrowDownRight />
                </div>
              </div>
              <h1>{formatToReal(dashboardData?.expense ?? '')}</h1>
            </div>

            <div className={style.card}>
              <div className={style.headerCard}>
                <span className={style.title}>Saldos</span>
                <div className={style.chartIcon}>
                  <ChartLine />
                </div>
              </div>
              <h1>{dashboardData?.balance.includes('-') ? '-' + formatToReal(dashboardData?.balance ?? '') : formatToReal(dashboardData?.balance ?? '')}</h1>
            </div>
          </section>

          <section className={style.charts}>
            <div className={style.cardChartLine}>
              <ChartLineArea
                data={[...dashboardData?.peerMonths || []].reverse()}
              />
            </div>

            <div className={style.cardPieChart}>
              <ChartPie
                values={dashboardData?.peerBudgets}
              />
            </div>
          </section>
        </div>

      </div>
    </MainTemplate>
  );
}