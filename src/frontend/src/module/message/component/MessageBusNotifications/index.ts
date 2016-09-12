import {Component, Directive} from "@angular/core";

import {MessageBusService} from "../../service/MessageBusService/index";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-message-bus-notifications'})
export class MessageBusNotifications
{
    constructor(private messageBusService: MessageBusService){}
}