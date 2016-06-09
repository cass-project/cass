import {Component} from "angular2/core";
import {AuthService} from "../../../auth/service/AuthService";
import {MessageBusService} from "../../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../message/component/MessageBusNotifications/model";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileDashboardRoute
{
    constructor(private messageBus: MessageBusService){
        this.getSignIn();
    }

    getSignIn(){
        if(!AuthService.isSignedIn()){
            this.messageBus.push(MessageBusNotificationsLevel.Info, "Вы не авторизованы");
        }
    }
}