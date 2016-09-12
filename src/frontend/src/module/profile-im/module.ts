import {Module} from "../common/classes/Module";

import {ProfileIMService} from "./service/ProfileIMService";
import {ProfileIMRoute} from "./route/ProfileIMRoute/index";

export = new Module({ 
    name: 'profile-im',
    providers: [
        ProfileIMService,
    ],
    routes: [
        {
            path: '/im/...',
            component: ProfileIMRoute
        },
    ]
});