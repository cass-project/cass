import {Module} from "../common/classes/Module";

import {AuthService} from "./service/AuthService";
import {AuthRESTService} from "./service/AuthRESTService";
import {AuthComponentService} from "./component/Auth/service";
import {AuthComponent} from "./component/Auth/index";

export = new Module({
    name: 'auth',
    RESTServices: [
        AuthRESTService,
    ],
    providers: [
        AuthService,
        AuthComponentService
    ],
    directives: [
        AuthComponent,
    ]
});