import {Component} from "@angular/core";

import {ProfileModal} from "./component/Modals/ProfileModal/index";
import {ModalComponent} from "../modal/component/index";
import {ProfileSwitcher} from "./component/Modals/ProfileSwitcher/index";
import {ProfileSetup} from "./component/Modals/ProfileSetup/index";
import {ModalBoxComponent} from "../modal/component/box/index";
import {AuthService} from "../auth/service/AuthService";
import {ProfileModals} from "./modals";
import {ProfileInterestsModal} from "./component/Modals/ProfileInterests/index";
import {MessageBusService} from "../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../message/component/MessageBusNotifications/model";
import {CollectionCreateMaster} from "../collection/component/Modal/CollectionCreateMaster/index";
import {Session} from "../session/Session";

@Component({
    selector: 'cass-profile',
    template: require('./template.jade'),
    providers: []
})
export class ProfileComponent
{
    constructor(private authService: AuthService, private session: Session, private modals: ProfileModals, protected messages: MessageBusService) {}
    
    closeModalProfileSwitcher($event){
        if($event){
            this.modals.switcher.close();
        }
    }
    
    closeModalCollectionCreateMaster($event){
        if($event){
            this.modals.createCollection.close();
        }
    }
    
    closeModalSettings($event){
        if($event){
            this.modals.settings.close();
        }
    }
    
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
            let testProfileIsInitialized = ! this.session.getCurrentProfile().entity.profile.is_initialized;
            let testIsOpened = this.modals.setup.isOpened();

            return testProfileIsInitialized || testIsOpened;
        }else{
            return false;
        }
    }
}