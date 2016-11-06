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
import {ContentGatewayRoute} from "./route/sources/ContentRoute/index";
import {ProfilesRoute} from "./route/sources/ProfilesRoute/index";
import {PublicRoute} from "./route/root/index";
import {PublicContentMenu} from "./route/sources/ContentRoute/component/PublicContentMenu/index";
import {NotEnoughCommunities} from "./route/sources/CommunitiesRoute/component/NotEnoughCommunities/index";
import {NotEnoughCollections} from "./route/sources/CollectionsRoute/component/NotEnoughCollections/index";
import {CollectionCatalogMenu} from "./route/sources/CollectionsRoute/component/CollectionCatalogMenu/index";
import {ContentRoute} from "./route/sources/ContentRoute/route/ContentRoute/index";
import {ThemesRoute} from "./route/sources/ContentRoute/route/ThemesRoute/index";
import {ProfilesThemesRoute} from "./route/sources/ProfilesRoute/route/ProfilesThemesRoute/index";
import {ProfilesFeedRoute} from "./route/sources/ProfilesRoute/route/ProfilesFeedRoute/index";
import {PublicProfilesMenu} from "./route/sources/ProfilesRoute/component/PublicProfilesMenu/index";

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
        NotEnoughCommunities,
        NotEnoughCollections,
        CollectionCatalogMenu,
        PublicProfilesMenu,
    ],
    routes: [
        PublicRoute,
        ThemesRoute,
        CollectionsRoute,
        CommunitiesRoute,
        ContentRoute,
        ContentGatewayRoute,
        ProfilesRoute,
        ProfilesThemesRoute,
        ProfilesFeedRoute,
    ],
    providers: [
        ViewOptionService,
    ],
};