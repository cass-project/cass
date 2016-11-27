import {SubscribeButton} from "./component/Elements/SubscribeButton/index";
import {SubscribeRESTService} from "./service/SubscribeRESTService";
import {NothingSubscribedTo} from "./component/Elements/NothingSubscribedTo/index";

export const CASSSubscribeModule = {
    declarations: [
        SubscribeButton,
        NothingSubscribedTo,
    ],
    providers: [
        SubscribeRESTService,
    ]
};