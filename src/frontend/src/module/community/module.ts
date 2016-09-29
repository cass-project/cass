import {CommunityRESTService} from "./service/CommunityRESTService";
import {CommunityFeaturesService} from "./service/CommunityFeaturesService";
import {CommunityModalService} from "./service/CommunityModalService";
import {CommunityComponent} from "./component/Elements/Community/index";
import {CommunityCard} from "./component/Elements/CommunityCard/index";
import {CommunityCardHeader} from "./component/Elements/CommunityCardHeader/index";
import {CommunityCardsList} from "./component/Elements/CommunityCardsList/index";
import {CommunityCreateCollectionCard} from "./component/Elements/CommunityCreateCollectionCard/index";
import {CommunityHeader} from "./component/Elements/CommunityHeader/index";
import {CommunityImage} from "./component/Elements/CommunityImage/index";
import {CommunitySettingsCard} from "./component/Elements/CommunitySettingsCard/index";
import {CommunityDashboardRoute} from "./route/CommunityDashboardRoute/index";
import {CommunityCollectionsRoute} from "./route/CommunityCollectionsRoute/index";
import {CommunityCollectionsListRoute} from "./route/CommunityCollectionsListRoute/index";
import {CommunityCollectionNotFoundRoute} from "./route/CommunityCollectionNotFoundRoute/index";
import {CommunityCollectionRoute} from "./route/CommunityCollectionRoute/index";
import {CommunityCreateModal} from "./component/Modals/CommunityCreateModal/index";
import {CommunityJoinModal} from "./component/Modals/CommunityJoinModal/index";
import {CommunityRouteModal} from "./component/Modals/CommunityRouteModal/index";
import {CommunitySettingsModal} from "./component/Modals/CommunitySettingsModal/index";
import {CommunityRoute} from "./route/CommunityRoute/index";
import {CommunityNotFoundRoute} from "./route/CommunityNotFoundRoute/index";
import {CommunitySettingsModalModel} from "./component/Modals/CommunitySettingsModal/model";
import {CommunityModals} from "./component/Elements/Community/modals";
import {CommunityResolve} from "./resolve/CommunityResolve";

export const CASSCommunityModal = {
    declarations: [
        CommunityComponent,
        CommunityCard,
        CommunityCardHeader,
        CommunityCardsList,
        CommunityCreateCollectionCard,
        CommunityHeader,
        CommunityImage,
        CommunitySettingsCard,
        CommunityCreateModal,
        CommunityJoinModal,
        CommunityRouteModal,
        CommunitySettingsModal,
    ],
    routes: [
        CommunityRoute,
        CommunityNotFoundRoute,
        CommunityDashboardRoute,
        CommunityCollectionsRoute,
        CommunityCollectionsListRoute,
        CommunityCollectionRoute,
        CommunityCollectionNotFoundRoute,
    ],
    providers: [
        CommunityRESTService,
        CommunityFeaturesService,
        CommunityModalService,
        CommunitySettingsModalModel,
        CommunityModals,
        CommunityResolve
    ],
};