import {Injectable} from "@angular/core";

import {ModalControl} from "../../../common/classes/ModalControl";

@Injectable()
export class AuthModalsService
{
    public signInModal: ModalControl = new ModalControl();
    public signUpModal: ModalControl = new ModalControl();
    public signInWithAPIKeyModal: ModalControl = new ModalControl();
    
    signUp() {
        this.closeAllModals();
        this.signUpModal.open();
    }

    signIn() {
        this.closeAllModals();
        this.signInModal.open();
    }

    signInWithAPIKey(){
        this.closeAllModals();
        this.signInWithAPIKeyModal.open();
    }

    closeAllModals() {
        this.signInModal.close();
        this.signUpModal.close();
        this.signInWithAPIKeyModal.close();
    }
}