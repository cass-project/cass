import {Module} from "../common/classes/Module";

import {ProfileIMService} from "./service/ProfileIMService";
import {ProfileIMRESTService} from "./service/ProfileIMRESTService";
import {ProfileIMRoute} from "./route/ProfileIMRoute/index";

export = new Module({ 
    name: 'profile-im',
    RESTServices: [
        ProfileIMRESTService,
    ],
    providers: [
        ProfileIMService,
    ],
    directives: [],
    routes: [
        {
            name: 'ProfileIM',
            path: '/im/...',
            component: ProfileIMRoute
        },
    ]
});