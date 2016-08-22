import {Module} from "../common/classes/Module";
import {AccountComponent} from "./index";
import {AccountRESTService} from "./service/AccountRESTService";
import {Session} from "../session/Session";

export = new Module({
    name: 'account',
    RESTServices: [
        AccountRESTService,
    ],
    providers: [
        Session,
    ],
    directives: [
        AccountComponent,
    ]
});