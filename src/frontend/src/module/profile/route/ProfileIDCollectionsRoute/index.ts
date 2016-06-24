import {Component} from "angular2/core";
import {RouteConfig, RouterOutlet, ROUTER_DIRECTIVES, ROUTER_PROVIDERS, RouteParams} from "angular2/router";
import {MessageBusService} from "../../../message/service/MessageBusService/index";
import {AuthService} from "../../../auth/service/AuthService";
import {MessageBusNotificationsLevel} from "../../../message/component/MessageBusNotifications/model";


@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileIDCollectionsRoute
{
    constructor(private messageBus: MessageBusService, params: RouteParams){
        this.sid = params.get('sid');
        console.log(this.sid);
    }

    sid: string;
}
