import {Injectable} from "angular2/core";

import {MessageBusNotificationsModel} from "../../component/MessageBusNotifications/model";
import {MessageBusInterface} from "./interface";
import {MessageBusNotificationsLevel} from "../../component/MessageBusNotifications/model";
import {MessageBusNotificationsStates} from "../../component/MessageBusNotifications/model";

@Injectable()
export class MessageBusService implements MessageBusInterface
{   
    public notifications:MessageBusNotificationsModel[] = [];

    private autoIncrementIndex:number = 0;
    private maxNotifications:number = 3;
    private notificationDelay:number = 12 /*sec*/ * 1000 /*ms*/;

    push(level: MessageBusNotificationsLevel, message: string) {

        let notification:MessageBusNotificationsModel = {
            id: this.autoIncrementIndex++,
            level: level,
            message: message,
            state: MessageBusNotificationsStates.Showing,
            timeout: setTimeout(() => {
                this.hidding(notification);
            }, this.notificationDelay)
        };

        this.notifications.push(notification);

        while(this.getNotifications().length > this.maxNotifications) {
            this.remove(this.getNotifications()[0]);
        }

        return this.notifications;
    }

    replaceLast(level: MessageBusNotificationsLevel, message: string) {
        let lastNotification:MessageBusNotificationsModel = this.notifications[this.notifications.length-1];
        this.remove(lastNotification);
        this.push(level, message);
    }
    
    remove(notification) {
        clearTimeout(notification.timeout);
        delete this.notifications[this.notifications.indexOf(notification)];
    }

    hidding(notification){
        let i = this.notifications.indexOf(notification);
        this.notifications[i].state = MessageBusNotificationsStates.Hidding;
        this.notifications[i].timeout = setTimeout(() => {
            this.remove(notification);
        }, 300);
    }

    getNotifications() : MessageBusNotificationsModel[] {
        return this.notifications.filter((input) => { return input !== undefined; })
    }

    debug(json: Object) {
        this.push(MessageBusNotificationsLevel.Debug, JSON.stringify(json));
    }
}

