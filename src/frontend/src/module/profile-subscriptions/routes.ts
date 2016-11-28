import {SubscriptionsCollectionsRoute} from "./routes/ByType/SubscriptionsCollectionsRoute/index";
import {SubscriptionsThemesRoute} from "./routes/ByType/SubscriptionsThemesRoute/index";
import {SubscriptionsCommunitiesRoute} from "./routes/ByType/SubscriptionsCommunitiesRoute/index";
import {SubscriptionsPeopleRoute} from "./routes/ByType/SubscriptionsPeopleRoute/index";

export const PROFILE_SUBSCRIPTION_ROUTES = [
    {
        path: '',
        redirectTo: 'themes',
        pathMatch: 'full'
    },

    {
        path: 'themes',
        component: SubscriptionsThemesRoute,
    },

    {
        path: 'collections',
        component: SubscriptionsCollectionsRoute,
    },

    {
        path: 'communities',
        component: SubscriptionsCommunitiesRoute,
    },
    {
        path: 'people',
        component: SubscriptionsPeopleRoute,
    }
];