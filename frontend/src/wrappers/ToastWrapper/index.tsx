import type React from "react";
import { ToastContainer, Zoom } from "react-toastify";

type ToastWrapperProps = {
  children: React.ReactNode
};

export function ToastWrapper({ children }: ToastWrapperProps) {

  return (
    <>
      {children}
      <ToastContainer
        position="top-center"
        autoClose={3000}
        theme="dark"
        transition={Zoom}
        draggable={false}
      />
    </>
  );
}