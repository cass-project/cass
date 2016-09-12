import {Module} from "../common/classes/Module";

import {ProfileSwitcherService} from "./component/Modals/ProfileSwitcher/service";
import {ProfileRESTService} from "./service/ProfileRESTService";
import {ProfileCachedIdentityMap} from "./service/ProfileCachedIdentityMap";
import {ProfileModals} from "./modals";
import {ProfileComponent} from "./index";
import {ProfileRootRoute} from "./route/ProfileRootRoute/index";
import {ProfileModalModel} from "./component/Modals/ProfileModal/model";
import {Session} from "../session/Session";

export = new Module({ 
    name: 'profile',
    RESTServices: [
        ProfileRESTService,
    ],
    providers: [
        Session,
        ProfileSwitcherService,
        ProfileCachedIdentityMap,
        ProfileModals,
        ProfileModalModel, // @deprecated
    ],
    routes: [
        {
            path: '/profile/...',
            component: ProfileRootRoute
        },
    ]
});