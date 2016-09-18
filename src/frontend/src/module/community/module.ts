import {NgModule} from '@angular/core';

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
import {CommunityMenuComponent} from "./component/Menu/index";
import {CommunitySettingsCard} from "./component/Elements/CommunitySettingsCard/index";
import {CommunityCreateModal} from "./component/Modal/CommunityCreateModal/index";
import {CommunityJoinModal} from "./component/Modal/CommunityJoinModal/index";
import {CommunityRouteModal} from "./component/Modal/CommunityRouteModal/index";
import {CommunitySettingsModal} from "./component/Modal/CommunitySettingsModal/index";

@NgModule({
    declarations: [
        CommunityComponent,
        CommunityCard,
        CommunityCardHeader,
        CommunityCardsList,
        CommunityCreateCollectionCard,
        CommunityHeader,
        CommunityImage,
        CommunityMenuComponent,
        CommunitySettingsCard,
        CommunityCreateModal,
        CommunityJoinModal,
        CommunityRouteModal,
        CommunitySettingsModal,
    ],
    providers: [
        CommunityRESTService,
        CommunityFeaturesService,
        CommunityModalService,
    ]
})
export class CASSCommunityModal {}