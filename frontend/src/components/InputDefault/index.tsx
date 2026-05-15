import { useState, type ComponentProps } from "react"
import style from './style.module.css';
import { EyeClosedIcon, EyeIcon } from "lucide-react";

type InputDefaultPropos = {
  label: string,
  type: 'text' | 'number' | 'password' | 'email' | 'date'
} & ComponentProps<'input'>

export function InputDefault({ label, type, ...props }: InputDefaultPropos) {

  const [showPassword, setShowPassword] = useState(false);
  const isPassword = type === 'password';


  return (
    <>
      <div className={style.inputContainer}>
        <label htmlFor={label} className={style.label}>
          {label}
        </label>

        <div className={style.inputContainerPassword}>
          <input
            id={label}
            className={style.input}
            type={
              isPassword
                ? (showPassword ? 'text' : 'password')
                : type
            }
            {...props}
          />

          {isPassword && (
            <button
              type="button"
              className={style.eyeButton}
              onClick={() => setShowPassword(!showPassword)}
            >
              {showPassword ? (
                <EyeClosedIcon width={20} />
              ) : (
                <EyeIcon width={20} />
              )}
            </button>
          )}
        </div>
      </div>
    </>
  );
}