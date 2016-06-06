import {Component} from "angular2/core";

import {ProfileComponentService} from "./service";
import {ProfileModal} from "./component/ProfileModal/index";
import {ModalComponent} from "../modal/component/index";
import {ProfileSwitcher} from "./component/ProfileSwitcher/index";
import {ProfileSetup} from "./component/ProfileSetup/index";
import {AuthService} from "../auth/service/AuthService";
import {Profile} from "./entity/Profile";
import {ModalBoxComponent} from "../modal/component/box/index";

@Component({
    selector: 'cass-profile',
    template: require('./template.html'),
    directives: [
        ModalComponent,
        ModalBoxComponent,
        ProfileModal,
        ProfileSwitcher,
        ProfileSetup
    ]
})
export class ProfileComponent
{
    currentProfile;

    constructor(private service: ProfileComponentService) {
        if(AuthService.isSignedIn()) {
            this.currentProfile = JSON.parse(JSON.stringify(AuthService.getAuthToken().getCurrentProfile().entity));
        }
    }
}