import {Component} from "angular2/core";

import {ProfileModal} from "./component/Modals/ProfileModal/index";
import {ModalComponent} from "../modal/component/index";
import {ProfileSwitcher} from "./component/Modals/ProfileSwitcher/index";
import {ProfileSetup} from "./component/Modals/ProfileSetup/index";
import {ModalBoxComponent} from "../modal/component/box/index";
import {AuthService} from "../auth/service/AuthService";
import {ProfileEntity} from "./definitions/entity/Profile";
import {ProfileModals} from "./modals";
import {ProfileInterestsModal} from "./component/Modals/ProfileInterests/index";

@Component({
    selector: 'cass-profile',
    template: require('./template.jade'),
    directives: [
        ModalComponent,
        ModalBoxComponent,
        ProfileModal,
        ProfileSwitcher,
        ProfileInterestsModal,
        ProfileSetup
    ]
})
export class ProfileComponent
{
    constructor(private authService: AuthService, private modals: ProfileModals) {}

    isSetupRequired() {
        if(this.authService.isSignedIn()) {
            let testProfileIsInitialized = ! this.authService.getCurrentAccount().getCurrentProfile().entity.profile.is_initialized;
            let testIsOpened = this.modals.setup.isOpened();

            return testProfileIsInitialized || testIsOpened;
        }else{
            return false;
        }
    }

    getCurrentProfile(): ProfileEntity {
        return this.authService.getCurrentAccount().getCurrentProfile().entity.profile;
    }
}