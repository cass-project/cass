import {Module} from "../common/classes/Module";

import {MessageBusService} from "./service/MessageBusService/index";
import {MessageBusNotifications} from "./component/MessageBusNotifications/index";

export = new Module({ 
    name: 'message',
    RESTServices: [],
    providers: [
        MessageBusService,
    ],
    directives: [
        MessageBusNotifications,
    ]
});