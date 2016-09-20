import {
    MessageBusNotificationsModel,
    MessageBusNotificationsLevel
} from "../../component/MessageBusNotifications/model";

export interface MessageBusInterface
{
    push(level: MessageBusNotificationsLevel, message: string) : MessageBusNotificationsModel[];
    debug(json: Object);
}