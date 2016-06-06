import {Component} from "angular2/core";
import {AuthComponent} from "../auth/component/Auth/index";
import {ProfileSetup} from "../profile/component/ProfileSetup/index";
import {ThemeSelect} from "../theme/component/ThemeSelect/index";
import {ProfileComponentService} from "../profile/service";
import {AuthService} from "../auth/service/AuthService";
import {MessageBusNotifications} from "../message/component/MessageBusNotifications/index";
import {MessageBusService} from "../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../message/component/MessageBusNotifications/model";

@Component({
    template: require('./template.html'),
    directives: [
        AuthComponent,
        ProfileSetup,
        ThemeSelect,
        MessageBusNotifications
    ],
    providers:[MessageBusService]
})
export class LandingComponent
{
    constructor(private pService: ProfileComponentService, private auth: AuthService, private messageBusService: MessageBusService) {
        /*if(!AuthService.getAuthToken().getCurrentProfile().entity.is_initialized){
            this.pService.modals.setup.open();
        }*/
    }

    busNotificationMessage:string;
    busNotificationLevel:MessageBusNotificationsLevel = MessageBusNotificationsLevel.Info;

    push(){
        this.messageBusService.push(this.busNotificationLevel, this.busNotificationMessage);
    }
}