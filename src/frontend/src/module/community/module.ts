import {Module} from "../common/classes/Module";

import {CommunityModalService} from "./service/CommunityModalService";
import {CommunityRESTService} from "./service/CommunityRESTService";
import {CommunityService} from "./service/CommunityService";
import {CommunitySettingsModalModel} from "./component/Modal/CommunitySettingsModal/model";
import {CommunityModals} from "./modals";
import {CommunityCreateModalNotifier} from "./component/Modal/CommunityCreateModal/notify";

export = new Module({ 
    name: 'community',
    RESTServices: [
        CommunityRESTService,
    ],
    providers: [
        CommunityService,
        CommunityModalService,
        CommunitySettingsModalModel,
        CommunityModals,
        CommunityCreateModalNotifier
    ],
});