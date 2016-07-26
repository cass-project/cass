import {Module} from "../common/classes/Module";

import {CurrentProfileService} from "./service/CurrentProfileService";
import {ProfileSwitcherService} from "./component/Modals/ProfileSwitcher/service";
import {ProfileRESTService} from "./service/ProfileRESTService";
import {ProfileCachedIdentityMap} from "./service/ProfileCachedIdentityMap";
import {ProfileModals} from "./modals";
import {ProfileComponent} from "./index";
import {ProfileRootRoute} from "./route/ProfileRootRoute/index";
import {ProfileModalModel} from "./component/Modals/ProfileModal/model";

export = new Module({ 
    name: 'profile',
    RESTServices: [
        ProfileRESTService,
    ],
    providers: [
        CurrentProfileService,
        ProfileSwitcherService,
        ProfileCachedIdentityMap,
        ProfileModals,
        ProfileModalModel, // @deprecated
    ],
    directives: [
        ProfileComponent,
    ],
    routes: [
        {
            name: 'Profile',
            path: '/profile/...',
            component: ProfileRootRoute
        },
    ]
});