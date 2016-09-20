import {MessageBusService} from "./service/MessageBusService/index";
import {MessageBusNotifications} from "./component/MessageBusNotifications/index";

export const CASSMessageModule = {
    declarations: [
        MessageBusNotifications,
    ],
    providers: [
        MessageBusService,
    ]
};