import axios from "axios";


export function getMessageError(error: unknown) {

  let messageError = 'Error';

  if (axios.isAxiosError(error)) {
    const errors = error.response?.data.errors;

    for (const error in errors) {
      messageError = errors[error][0];
      break;
    }
  }

  return messageError;

}