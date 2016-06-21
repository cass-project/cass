import {Component} from "angular2/core";
import {RouteParams, Router} from "angular2/router";

import {CommunityService} from "../../service/CommunityService";
import {ModalComponent} from "../../../modal/component";
import {ModalBoxComponent} from "../../../modal/component/box";
import {LoadingLinearIndicator} from "../../../util/component/LoadingLinearIndicator";
import {CommunitySettingsModalModel} from "../../component/Modal/CommunitySettingsModal/model";
import {MessageBusService} from "../../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../message/component/MessageBusNotifications/model";

@Component({
    selector: "community-page",
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
        LoadingLinearIndicator
    ]
})
export class CommunityPage
{
    public isLoading:boolean = false;

    constructor (
        private routeParams: RouteParams,
        private router: Router,
        private service: CommunityService,
        private messages: MessageBusService,
        private model:CommunitySettingsModalModel
    ){
        let timeout = setTimeout(()=>{ this.isLoading=true;}, 1000);
        model.sid = this.routeParams.get('sid');
        this.service.getBySid(model.sid).subscribe(
            data => {
                this.isLoading = false;
                clearTimeout(timeout);
            },
            error => {
                error._body = JSON.parse(error._body);
                if(error.status === 404) {
                    this.messages.push(MessageBusNotificationsLevel.Critical, error._body.error)
                    this.router.navigateByUrl("/");
                } else {
                    console.log(error);
                }
                this.isLoading = false;
                clearTimeout(timeout);
            }
        );
    }

    reset() {
        this.service.community = undefined;
        this.service.isAdmin = false;
    }
}