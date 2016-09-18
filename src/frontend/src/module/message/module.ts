import {NgModule} from '@angular/core';

import {MessageBusService} from "./service/MessageBusService/index";
import {MessageBusNotifications} from "./component/MessageBusNotifications/index";

@NgModule({
    declarations: [
        MessageBusNotifications,
    ],
    providers: [
        MessageBusService,
    ]
})
export class CASSMessageModule {}