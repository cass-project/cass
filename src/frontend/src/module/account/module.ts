import {AccountComponent} from "./component/Account/index";
import {AccountRESTService} from "./service/AccountRESTService";
import {AccountDeleteWarning} from "./component/AccountDeleteWarning/index";

export const CASSAccountModule = {
    declarations: [
        AccountComponent,
        AccountDeleteWarning
    ],
    providers: [
        AccountRESTService,
    ]
};