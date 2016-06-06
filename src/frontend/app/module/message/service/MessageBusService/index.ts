import {Injectable} from "angular2/core";
import {Http} from 'angular2/http';
import {MessageBusNotificationsModel} from "../../component/MessageBusNotifications/model";
import {MessageBusInterface} from "./interface";
import {MessageBusNotificationsLevel} from "../../component/MessageBusNotifications/model";

@Injectable()
export class MessageBusService implements MessageBusInterface
{
    public notifications:MessageBusNotificationsModel[] = [];

    private autoIncrementIndex:number = 0;
    private maxNotifications:number = 3;
    private notificationDelay:number = 5 /*sec*/ * 1000 /*ms*/;

    constructor(private http:Http) {}

    push(level: MessageBusNotificationsLevel, message: string) : MessageBusNotificationsModel[] {
        let notification:MessageBusNotificationsModel = {
            id: this.autoIncrementIndex++,
            level: level,
            date: new Date(),
            message: message,
        };

        this.notifications.push(notification);

        if(this.notifications.length > 3) {
            this.notifications.splice(0, this.notifications.length-3);
        }

        setTimeout(()=> {
            this.notifications = this.notifications.filter((input) => {
                return input.id !== notification.id;
            });
        }, this.notificationDelay);

        return this.notifications;
    }

    debug(json: Object) {
        this.push(MessageBusNotificationsLevel.Debug, JSON.stringify(json));
    }
}

