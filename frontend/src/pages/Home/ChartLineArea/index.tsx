import { RechartsDevtools } from "@recharts/devtools";
import { useEffect, useState } from "react";
import { Area, AreaChart, Legend, Tooltip, XAxis, YAxis, type DataKey, type LegendPayload } from "recharts";
import type { ValuesPeerDataDashboard } from "../../../types/ValuesPeerDataDashboard";
import style from './style.module.css';
import { useFormatToReal } from "../../../hooks/useDisplayValues";

type ChartLineData = {
  data: ValuesPeerDataDashboard[] | undefined
}

export function ChartLineArea({ data }: ChartLineData) {

  const [hoveringDataKey, setHoveringDataKey] = useState<DataKey<any> | undefined>(undefined);

  const formatToReal = useFormatToReal();

  const incomeOpacity = hoveringDataKey === 'Receitas' ? 0.8 : .4;
  const expenseOpacity = hoveringDataKey === 'Despesas' ? 0.8 : .4;

  useEffect(() => {


  }, [hoveringDataKey]);

  const handleMouseEnter = (payload: LegendPayload) => {
    setHoveringDataKey(payload.dataKey);
  };

  const handleMouseLeave = () => {
    setHoveringDataKey(undefined);
  };

  return (
    <AreaChart
      className={style.chart}
      responsive
      data={Object.values(data ?? [])}
    >
      <defs>
        <linearGradient id="colorUv" x1="0" y1="0" x2="0" y2="1" >
          <stop offset="5%" stopColor="#49c53d" stopOpacity={incomeOpacity} />
          <stop offset="95%" stopColor="#49c53d" stopOpacity={0} />
        </linearGradient>
        <linearGradient id="colorPv" x1="0" y1="0" x2="0" y2="1" >
          <stop offset="5%" stopColor="#d12222" stopOpacity={expenseOpacity} />
          <stop offset="95%" stopColor="#d12222" stopOpacity={0} />
        </linearGradient>
      </defs>
      <XAxis
        dataKey="month"
        tickLine={false}
        axisLine={false}
        tickMargin={12}
      />
      <YAxis
        width="auto"
        tickFormatter={(e) =>  new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL',
          }).format(Number(e))}
        tickLine={false}
        axisLine={false}
        tickMargin={12}
        domain={[0, 10000]}
      />
      <Tooltip
        formatter={(e) => `${formatToReal(e?.toString() ?? '')}`}
        contentStyle={{
          backgroundColor: '#111827',
          borderColor: '#374151',
          borderRadius: '8px',
          fontWeight: 'bold'
        }}
        labelStyle={{
          color: '#9ca3af',
          fontWeight: 'bold'
        }}
      />
      <Legend onMouseEnter={handleMouseEnter} onMouseLeave={handleMouseLeave} />
      <Area
        type="monotone"
        dataKey="Receitas"
        stroke="#84d88b"
        fillOpacity={1}
        fill="url(#colorUv)"
        isAnimationActive={true}
      />
      <Area
        type="monotone"
        dataKey="Despesas"
        stroke="#be3030"
        fillOpacity={1}
        fill="url(#colorPv)"
        isAnimationActive={true}
      />
      <RechartsDevtools />
    </AreaChart>
  );
}