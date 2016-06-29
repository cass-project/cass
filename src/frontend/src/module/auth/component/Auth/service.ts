import {Injectable} from "angular2/core";
import {ModalControl} from "../../../util/classes/ModalControl";

@Injectable()
export class AuthComponentService
{
    private modals: {
        signIn: ModalControl,
        signUp: ModalControl
    } = {
        signIn: new ModalControl(),
        signUp: new ModalControl()
    };

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
    }
}