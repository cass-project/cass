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
import {MessageBusService} from "../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../message/component/MessageBusNotifications/model";

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
    constructor(private authService: AuthService, private modals: ProfileModals, protected messages: MessageBusService) {}

    closeModalInterests($event){
        if($event){
            this.modals.interests.close(); 
        }
    }
    
    successModalInteresrs($event){
        if($event) {
            this.messages.push(MessageBusNotificationsLevel.Info, 'Мы сохранили информацию о ваших интересах');
            this.modals.interests.close();
        }
    }
    
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