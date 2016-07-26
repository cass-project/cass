import {Module} from "../common/classes/Module";

import {ContactService} from "./service/ContactService";
import {ContactRESTService} from "./service/ContactRESTService";

export = new Module({ 
    name: 'contact',
    RESTServices: [
        ContactRESTService,
    ],
    providers: [
        ContactService,
    ],
    directives: []
});