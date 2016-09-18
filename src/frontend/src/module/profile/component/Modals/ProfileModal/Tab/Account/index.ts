import {Component} from "@angular/core";
import {ProfileRESTService} from "../../../../../service/ProfileRESTService";
import {ProfileModalModel} from "../../model";
import {AccountRESTService} from "../../../../../../account/service/AccountRESTService";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-profile-modal-tab-account'})

export class AccountTab
{
    private requestButtonDisabled: boolean = false;
    private flagAccountIsDeleted: boolean = false;

    constructor(private service: AccountRESTService, private model: ProfileModalModel) {}

    deleteAccount() {
        this.service.requestDelete().subscribe(data => {
            this.flagAccountIsDeleted = false
        });
    }

    requestDeleteAccount() {
        this.requestButtonDisabled = true;

        setTimeout(() => {
            this.flagAccountIsDeleted = true;
            this.requestButtonDisabled = false;
        }, 1000);
    }

    cancelDeleteAccountRequest() {
        this.service.cancelRequestDelete().subscribe(data => {
            this.flagAccountIsDeleted = false;
        });
    }

    isDeleteAccountRequested():boolean {
        return this.flagAccountIsDeleted;
    }
}