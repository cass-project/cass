import {Module} from "../common/classes/Module";

import {IMRESTService} from "./service/IMRESTService";

export = new Module({ 
    name: 'im',
    RESTServices: [
        IMRESTService,
    ],
    providers: [],
    directives: []
});