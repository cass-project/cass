import {Component} from "angular2/core";
import {RouteConfig, RouterOutlet, ROUTER_DIRECTIVES, ROUTER_PROVIDERS, RouteParams, Router} from "angular2/router";
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
    constructor(private messageBus: MessageBusService, private router: Router){
        if(AuthService.isSignedIn()){
            this.router.navigate(['ProfileCurrentCollectionsRoute']); /*ToDo: редирект на дефолтную коллекцию*/

        } else{
            this.messageBus.push(MessageBusNotificationsLevel.Info, "Вы не авторизованы");
        }
    }
}