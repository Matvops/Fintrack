import { Legend, Pie, PieChart, Tooltip } from 'recharts';
import { RechartsDevtools } from '@recharts/devtools';
import type { ValuesPeerBudgetDashboard } from '../../../types/ValuesPeerBudgetDashboard';
import { useFormatToReal } from '../../../hooks/useDisplayValues';

type ChartPieData = {
  values: ValuesPeerBudgetDashboard[] | undefined
}


export function ChartPie({ values }: ChartPieData) {

  const formatToReal = useFormatToReal();

  const colorMap: Record<string, string> = {
    ambar: '#F59E0B',
    rosa: '#EC4899',
    violeta: '#8B5CF6',
    azul: '#3B82F6',
    esmeralda: '#10B981',
  };

  values = values?.map(value => ({
    ...value,
    fill: colorMap[value.color] ?? '#94a3b8',
  }));


  return (
    <PieChart
      style={{ width: '100%', height: '100%', maxWidth: '500px', maxHeight: '80vh', aspectRatio: 1, cursor: 'pointer' }}
      responsive
    >
      <Pie
        data={values}
        dataKey="value"
        cx="50%"
        cy="50%"
        innerRadius="60%"
        outerRadius="80%"
        isAnimationActive={true}

      />
      <Tooltip
        formatter={(value) => formatToReal(value?.toString() ?? '')}
        contentStyle={{
          backgroundColor: '#111827',
          borderColor: '#374151',
          borderRadius: '8px',
          fontWeight: 'bold'
        }}
      />
      <Legend verticalAlign="bottom" />
      <RechartsDevtools />
    </PieChart>
  );
}