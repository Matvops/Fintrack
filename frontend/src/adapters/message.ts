import { toast } from "react-toastify";


export class message {

    static success(message: string) {
        toast.success(message);
    }
    
    static error(message: string) {
        toast.error(message);
    }

    static info(message: string) {
        toast.info(message);
    }

    static warning(message: string) {
        toast.warning(message);
    }

    static dismiss(message: string) {
        toast.dismiss(message);
    }
}