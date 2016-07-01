import {Component, Input} from "angular2/core";

import {ProfileRESTService} from "../../../../../service/ProfileRESTService";
import {ProfileModalModel} from "../../model";
import {AccountEntity} from "../../../../../../account/definitions/entity/Account";

@Component({
    selector: 'cass-profile-modal-tab-account',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class AccountTab
{
    @Input('account') account: AccountEntity;

    private requestButtonDisabled: boolean = false;
    private flagAccountIsDeleted: boolean = false;

    constructor(private profileRESTService:ProfileRESTService) {
        this.flagAccountIsDeleted = this.account.delete_request.has;
    }

    deleteAccount() {
        this.profileRESTService.requestAccountDelete().subscribe();
        this.flagAccountIsDeleted = false;
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