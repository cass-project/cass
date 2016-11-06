import {ContentTypeCriteria} from "./component/Criteria/ContentTypeCriteria/index";
import {QueryStringCriteria} from "./component/Criteria/QueryStringCriteria/index";
import {SeekCriteria} from "./component/Criteria/SeekCriteria/index";
import {ThemeCriteria} from "./component/Criteria/ThemeCriteria/index";
import {PublicComponent} from "./component/Public/index";
import {SourceSelector} from "./component/Elements/SourceSelector/index";
import {NothingFound} from "./component/Elements/NothingFound/index";
import {ViewOptionService} from "./component/Options/ViewOption/service";
import {CollectionsRoute} from "./route/sources/CollectionsRoute/index";
import {CommunitiesRoute} from "./route/sources/CommunitiesRoute/index";
import {ContentRoute} from "./route/sources/ContentRoute/index";
import {ProfilesRoute} from "./route/sources/ProfilesRoute/index";
import {PublicRoute} from "./route/root/index";
import {PublicContentMenu} from "./route/sources/ContentRoute/component/PublicContentMenu/index";
import {ProfilesThemesRoute} from "./route/sources/ProfilesRoute/route/ProfilesThemesRoute/index";
import {ProfilesFeedRoute} from "./route/sources/ProfilesRoute/route/ProfilesFeedRoute/index";
import {PublicProfilesMenu} from "./route/sources/ProfilesRoute/component/PublicProfilesMenu/index";
import {ContentThemesRoute} from "./route/sources/ContentRoute/route/ContentThemesRoute/index";
import {ContentFeedRoute} from "./route/sources/ContentRoute/route/ContentFeedRoute/index";
import {CollectionThemesRoute} from "./route/sources/CollectionsRoute/routes/CollectionThemesRoute/index";
import {CollectionFeedRoute} from "./route/sources/CollectionsRoute/routes/CollectionFeedRoute/index";
import {PublicCollectionsMenu} from "./route/sources/CollectionsRoute/component/PublicCollectionsMenu/index";
import {PublicCommunitiesMenu} from "./route/sources/CommunitiesRoute/component/PublicCommunitiesMenu/index";
import {CommunityFeedRoute} from "./route/sources/CommunitiesRoute/routes/CommunityFeedRoute/index";
import {CommunityThemesRoute} from "./route/sources/CommunitiesRoute/routes/CommunityThemesRoute/index";

export const CASSPublicComponent = {
    declarations: [
        PublicComponent,
        ContentTypeCriteria,
        QueryStringCriteria,
        SeekCriteria,
        ThemeCriteria,
        NothingFound,
        SourceSelector,
        PublicContentMenu,
        PublicProfilesMenu,
        PublicCollectionsMenu,
        PublicCommunitiesMenu,
    ],
    routes: [
        PublicRoute,

        ContentRoute,
        ContentThemesRoute,
        ContentFeedRoute,

        CollectionsRoute,
        CollectionFeedRoute,
        CollectionThemesRoute,

        CommunitiesRoute,
        CommunityFeedRoute,
        CommunityThemesRoute,

        ProfilesRoute,
        ProfilesThemesRoute,
        ProfilesFeedRoute,
    ],
    providers: [
        ViewOptionService,
    ],
};