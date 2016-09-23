import {ContentTypeCriteria} from "./component/Criteria/ContentTypeCriteria/index";
import {QueryStringCriteria} from "./component/Criteria/QueryStringCriteria/index";
import {SeekCriteria} from "./component/Criteria/SeekCriteria/index";
import {ThemeCriteria} from "./component/Criteria/ThemeCriteria/index";
import {PublicComponent} from "./component/Public/index";
import {SourceSelector} from "./component/Elements/SourceSelector/index";
import {NothingFound} from "./component/Elements/NothingFound/index";
import {CollectionsRoute} from "./route/CollectionsRoute/index";
import {CommunitiesRoute} from "./route/CommunitiesRoute/index";
import {ContentRoute} from "./route/ContentRoute/index";
import {ExpertsRoute} from "./route/ExpertsRoute/index";
import {ProfilesRoute} from "./route/ProfilesRoute/index";
import {ViewOptionService} from "./component/Options/ViewOption/service";

export const CASSPublicComponent = {
    declarations: [
        PublicComponent,
        ContentTypeCriteria,
        QueryStringCriteria,
        SeekCriteria,
        ThemeCriteria,
        NothingFound,
        SourceSelector,
    ],
    routes: [
        CollectionsRoute,
        CommunitiesRoute,
        ContentRoute,
        ExpertsRoute,
        ProfilesRoute,
    ],
    providers: [
        ViewOptionService,
    ],
};