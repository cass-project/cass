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
import {ExpertsRoute} from "./route/sources/ExpertsRoute/index";
import {PublicRoute} from "./route/root/index";
import {PublicContentMenu} from "./route/sources/ContentRoute/component/PublicContentMenu/index";
import {NotEnoughCommunities} from "./route/sources/CommunitiesRoute/component/NotEnoughCommunities/index";
import {NotEnoughCollections} from "./route/sources/CollectionsRoute/component/NotEnoughCollections/index";
import {ProfileCatalogMenu} from "./route/sources/ProfilesRoute/component/ProfileCatalogMenu/index";
import {CollectionCatalogMenu} from "./route/sources/CollectionsRoute/component/CollectionCatalogMenu/index";
import {ContentRoute} from "./route/sources/ContentRoute/route/ContentRoute/index";
import {ThemesRoute} from "./route/sources/ContentRoute/route/ThemesRoute/index";

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
        ProfileCatalogMenu,
        CollectionCatalogMenu,
        ThemesRoute,
    ],
    routes: [
        PublicRoute,
        CollectionsRoute,
        CommunitiesRoute,
        ContentRoute,
        ContentGatewayRoute,
        ExpertsRoute,
        ProfilesRoute,
    ],
    providers: [
        ViewOptionService,
    ],
};