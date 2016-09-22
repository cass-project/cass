import {Component} from "@angular/core";

import {ProfileModalModel} from "../../model";
import {AccountRESTService} from "../../../../../../account/service/AccountRESTService";

@Component({
    selector: 'cass-profile-modal-tab-account',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileModuleAccountTab
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