import {Component} from "angular2/core";
import {ProfileService} from "../../../ProfileService/ProfileService";
import {ProfileRESTService} from "../../../ProfileService/ProfileRESTService";
import {AvatarCropperService} from "../../../../../util/component/AvatarCropper/service";
import {ProfileModalModel} from "../../model";


@Component({
    selector: 'cass-profile-modal-tab-account',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class AccountTab
{
    constructor(public profileService: ProfileService,
                public profileRESTService: ProfileRESTService,
                public model: ProfileModalModel
    ){}



    requestButtonDisabled: boolean =false;
    flagDeleteAccount: boolean = false;


    deleteAccount(){
        this.profileRESTService.requestAccountDelete().subscribe();
        this.flagDeleteAccount = false;
    }

    requestDeleteAccount() {
        this.requestButtonDisabled = true;

        setTimeout(() => {
            this.flagDeleteAccount = true;
            this.requestButtonDisabled = false;
        }, 1000);
    }

    cancelDeleteAccountRequest() {
        //ToDo: I think its temporary;
        this.profileRESTService.requestAccountDeleteCancel().subscribe();
        this.flagDeleteAccount = false;
    }

    isDeleteAccountRequested(): boolean {
        return this.flagDeleteAccount;
    }
}