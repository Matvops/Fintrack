import style from './style.module.css';

type Value = {
  label: string,
  value: any
}

type DropdownGenericProps = {
  values: Value[],
  selectedValue: Value|undefined,
  setSelectedValue: React.Dispatch<React.SetStateAction<Value|undefined>>,
  title?: string,
  defaultLabel?: string
} & React.ComponentProps<'select'>

export function DropdownGeneric({ values, selectedValue, setSelectedValue, title, defaultLabel, ...props }: DropdownGenericProps) {

  function handleValue(id: number | string) {
    const selected = values.find(value => value.value == id);
    setSelectedValue(prevState => selected ?? prevState);
  }

  const getOptions = () => {

    return values?.map((value, key) => {

      const isValueSelected = selectedValue?.value === value?.value;

      return isValueSelected ?
        <option selected value={value.value} key={key}>{value.label}</option>
        :
        <option value={value.value} key={key}>{value.label}</option>

    })

  }

  return (
    <>
      <div className={style.selectContainer}>

        {title && <label className={style.title}>{title?.toUpperCase()}</label>}

        <select className={style.select} onChange={(e) => handleValue(e.target.value)} {...props}>

          {selectedValue ? 
            <option value={-1}>{defaultLabel ?? 'Selecione'}</option> 
            : 
            <option selected value={-1}>{defaultLabel ?? 'Selecione'}</option>
          }

          {getOptions()}
        </select>

      </div>
    </>
  );
}