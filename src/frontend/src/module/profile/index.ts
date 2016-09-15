import {Component} from "@angular/core";
import {AuthService} from "../auth/service/AuthService";
import {ProfileModals} from "./modals";
import {MessageBusService} from "../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../message/component/MessageBusNotifications/model";
import {Session} from "../session/Session";

@Component({
    template: require('./template.jade'),
    providers: [],selector: 'cass-profile'})

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