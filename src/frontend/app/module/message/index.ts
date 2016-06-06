import {Component} from "angular2/core";
import {MessageBusNotifications} from "./component/MessageBusNotifications/index";

@Component({
    template: require('./template.html'),
    directives: [
        MessageBusNotifications
    ]
})

export class Message
{
}