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
    flagDeleteAccount: boolean = false;

    requestDeleteAccount() {
        this.flagDeleteAccount = true;
    }

    cancelDeleteAccountRequest() {
        this.flagDeleteAccount = false;
    }

    isDeleteAccountRequested(): boolean {
        return this.flagDeleteAccount;
    }
}