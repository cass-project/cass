import {ProfileComponent} from "./component/Elements/Profile/index";
import {ProfileModals} from "./component/Elements/Profile/modals";
import {ProfileCard} from "./component/Elements/ProfileCard/index";
import {ProfileCachedIdentityMap} from "./service/ProfileCachedIdentityMap";
import {ProfileRESTService} from "./service/ProfileRESTService";
import {ProfileRoute} from "./route/ProfileRoute/index";
import {ProfileDashboardRoute} from "./route/ProfileDashboardRoute/index";
import {ProfileNotFoundRoute} from "./route/ProfileNotFoundRoute/index";
import {ProfileCollectionsRoute} from "./route/ProfileCollectionsRoute/index";
import {ProfileCollectionsListRoute} from "./route/ProfileCollectionsListRoute/index";
import {ProfileCollectionRoute} from "./route/ProfileCollectionRoute/index";
import {ProfileCollectionNotFoundRoute} from "./route/ProfileCollectionNotFoundRoute/index";

export const CASSProfileModule = {
    declarations: [
        ProfileComponent,
        ProfileCard,
    ],
    routes: [
        ProfileRoute,
        ProfileDashboardRoute,
        ProfileNotFoundRoute,
        ProfileCollectionsRoute,
        ProfileCollectionsListRoute,
        ProfileCollectionRoute,
        ProfileCollectionNotFoundRoute,
    ],
    providers: [
        ProfileModals,
        ProfileCachedIdentityMap,
        ProfileRESTService,
    ]
};