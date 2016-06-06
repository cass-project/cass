import {Component} from "angular2/core";
import {RouteParams, Router} from "angular2/router";
import {ModalComponent} from "../../../modal/component/index";
import {ModalBoxComponent} from "../../../modal/component/box/index";
import {LoadingLinearIndicator} from "../../../util/component/LoadingLinearIndicator/index";
import {MessageBusService} from "../../service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "./model";

@Component({
    selector: "cass-message-bus-notifications",
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class MessageBusNotifications
{
    constructor(private messageBusService: MessageBusService){}
}