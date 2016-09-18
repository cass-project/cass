import {Injectable} from "@angular/core";

import {ModalControl} from "../../../common/classes/ModalControl";

@Injectable()
export class AuthModalsService
{
    public signIn: ModalControl = new ModalControl();
    public signUp: ModalControl = new ModalControl();
    public authDev: ModalControl = new ModalControl();

    authDev(){
        this.closeAllModals();
        this.authDev.open();
    }
    
    signUp() {
        this.closeAllModals();
        this.signUp.open();
    }

    signIn() {
        this.closeAllModals();
        this.signIn.open();
    }

    closeAllModals() {
        this.signIn.close();
        this.signUp.close();
        this.authDev.close();
    }
}