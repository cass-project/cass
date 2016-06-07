import {Component} from "angular2/core";

import {MessageBusService} from "../../service/MessageBusService/index";

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