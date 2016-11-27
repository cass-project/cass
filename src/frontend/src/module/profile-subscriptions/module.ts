import {SubscriptionsRoute} from "./routes/SubscriptionsRoute/index";
import {SubscriptionsThemesRoute} from "./routes/ByType/SubscriptionsThemesRoute/index";
import {SubscriptionsCollectionsRoute} from "./routes/ByType/SubscriptionsCollectionsRoute/index";
import {SubscriptionsCommunitiesRoute} from "./routes/ByType/SubscriptionsCommunitiesRoute/index";
import {SubscriptionsPeopleRoute} from "./routes/ByType/SubscriptionsPeopleRoute/index";
import {NothingPosted} from "./component/NothingPosted/index";

export const CASSProfileSubscriptionsModule = {
    declarations: [
        NothingPosted,
    ],
    routes: [
        SubscriptionsRoute,
        SubscriptionsThemesRoute,
        SubscriptionsCollectionsRoute,
        SubscriptionsCommunitiesRoute,
        SubscriptionsPeopleRoute,
    ],
    providers: []
};