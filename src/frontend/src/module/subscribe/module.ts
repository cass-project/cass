import {SubscribeButton} from "./component/Elements/SubscribeButton/index";
import {SubscribeRESTService} from "./service/SubscribeRESTService";

export const CASSSubscribeModule = {
    declarations: [
        SubscribeButton,
    ],
    providers: [
        SubscribeRESTService,
    ]
};