import {Component, Input, Directive} from "@angular/core";

import {ProfileRESTService} from "../../../../../service/ProfileRESTService";
import {AccountEntity} from "../../../../../../account/definitions/entity/Account";
import {ProfileModalModel} from "../../model";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-profile-modal-tab-account'})

export class AccountTab
{
    private requestButtonDisabled: boolean = false;
    private flagAccountIsDeleted: boolean = false;

    constructor(private profileRESTService:ProfileRESTService, private model: ProfileModalModel) {}

    deleteAccount() {
        this.profileRESTService.requestAccountDelete().subscribe(data => {
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
        this.profileRESTService.requestAccountDeleteCancel().subscribe();
        this.flagAccountIsDeleted = false;
    }

    isDeleteAccountRequested():boolean {
        return this.flagAccountIsDeleted;
    }
}