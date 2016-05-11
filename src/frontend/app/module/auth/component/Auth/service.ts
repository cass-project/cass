import {Injectable} from "angular2/core";

@Injectable()
export class AuthComponentService
{
    public modals: ModalControls = new ModalControls();
}

class ModalControls
{
    currentModal: Modals = Modals.None;

    openSignInModal() {
        this.currentModal = Modals.SignIn;
    }

    isSignInModalOpened() {
        return this.currentModal === Modals.SignIn;
    }

    openSignUpModal() {
        this.currentModal = Modals.SignUp;
    }

    isSignUpModalOpened() {
        return this.currentModal === Modals.SignUp;
    }

    openSignOutModal() {
        this.currentModal = Modals.SignOut;
    }

    isSignOutModalOpened() {
        return this.currentModal === Modals.SignOut;
    }

    closeModals() {
        this.currentModal = Modals.None;
    }
}

enum Modals {
    None,
    SignIn,
    SignUp,
    SignOut
}
