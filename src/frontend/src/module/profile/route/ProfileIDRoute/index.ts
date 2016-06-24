import {Component} from "angular2/core";
import {RouteConfig, RouterOutlet, ROUTER_DIRECTIVES, ROUTER_PROVIDERS, RouteParams, Router} from "angular2/router";
import {MessageBusService} from "../../../message/service/MessageBusService/index";
import {AuthService} from "../../../auth/service/AuthService";
import {MessageBusNotificationsLevel} from "../../../message/component/MessageBusNotifications/model";
import {ProfileRESTService} from "../../service/ProfileRESTService";


@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileIDRoute
{
    sid: string;

    constructor(private messageBus: MessageBusService, params: RouteParams, private profileRESTService: ProfileRESTService, private router: Router){

        this.sid = params.get('sid');
        this.profileRESTService.getProfileById(this.sid).subscribe(
            data => {
            console.log(data);
            },
            err => {
                console.log(err.status);
                if(err.status === 404){
                    this.router.navigate(['ProfileNotFound']);
                } else if(err.status === 403){
                    this.router.navigateByUrl('/auth/sign-in');
                    this.messageBus.push(MessageBusNotificationsLevel.Warning, 'Вы не авторизованы');
                } else if(err.status){
                    this.messageBus.push(MessageBusNotificationsLevel.Critical, JSON.parse(err._body).error);
                    console.log();
                } else {
                    this.messageBus.push(MessageBusNotificationsLevel.Warning, 'Произошла ошибка. Похоже, у вас проблемы с интернетом!');
                }
            }
        );
    }
}
