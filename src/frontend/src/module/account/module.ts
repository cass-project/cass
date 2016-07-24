import {Module} from "../common/classes/Module";

import {CurrentAccountService} from "./service/CurrentAccountService";
import {AccountComponent} from "./index";
import {AccountRESTService} from "./service/AccountRESTService";

export = new Module({
    name: 'account',
    RESTServices: [
        AccountRESTService,
    ],
    providers: [
        CurrentAccountService,
    ],
    directives: [
        AccountComponent,
    ]
});