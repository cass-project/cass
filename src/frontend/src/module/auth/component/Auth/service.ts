import {Injectable} from "@angular/core";
import {ModalControl} from "../../../common/classes/ModalControl";

@Injectable()
export class AuthComponentService
{
    public modals: {
        signIn: ModalControl,
        signUp: ModalControl,
        authDev: ModalControl
    } = {
        signIn: new ModalControl(),
        signUp: new ModalControl(),
        authDev: new ModalControl()
    };
    
    
    authDev(){
        this.closeAllModals();
        this.modals.authDev.open();
    }
    
    signUp() {
        this.closeAllModals();
        this.modals.signUp.open();
    }

    signIn() {
        this.closeAllModals();
        this.modals.signIn.open();
    }

    closeAllModals() {
        this.modals.signIn.close();
        this.modals.signUp.close();
        this.modals.authDev.close();
    }
}