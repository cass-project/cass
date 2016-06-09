import {Component} from "angular2/core";
import {RouteConfig, RouterOutlet} from "angular2/router";
import {MessageBusService} from "../../../message/service/MessageBusService/index";
import {AuthService} from "../../../auth/service/AuthService";


@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class  ProfileCurrentRoute
{
    constructor(private messageBus: MessageBusService){}

    //getSignIn(){
    //    if(!AuthService.isSignedIn()){
    //        this.messageBus.push(info, "Вы не авторизованы");
    //    }
    //}
}
