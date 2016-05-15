import {Component} from "angular2/core";

@Component({
    selector: 'cass-profile-modal-tab-account',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class AccountTab
{
    requestButtonDisabled: boolean =false;
    flagDeleteAccount: boolean = false;

    requestDeleteAccount() {
        this.requestButtonDisabled = true;

        setTimeout(() => {
            this.flagDeleteAccount = true;
            this.requestButtonDisabled = false;
        }, 1000);
    }

    cancelDeleteAccountRequest() {
        this.flagDeleteAccount = false;
    }

    isDeleteAccountRequested(): boolean {
        return this.flagDeleteAccount;
    }
}