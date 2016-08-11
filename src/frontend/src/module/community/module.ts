import {Module} from "../common/classes/Module";
import {CommunityRootRoute} from "./route/CommunityRootRoute";
import {CommunityService} from "./service/CommunityService";
import {CommunityModalService} from "./service/CommunityModalService";
import {CommunityRESTService} from "./service/CommunityRESTService";
import {CommunityComponent} from "./index";
import {CommunityCreateModalNotifier} from "./component/Modal/CommunityCreateModal/notify";
import {CommunityJoinModalNotifier} from "./component/Modal/CommunityJoinModal/notify";
import {CommunitySettingsModalModel} from "./component/Modal/CommunitySettingsModal/model";

export = new Module({
    name: 'community1',
    RESTServices: [
        CommunityRESTService,
    ],
    providers: [
        CommunityService,
        CommunityModalService,
        CommunityCreateModalNotifier,
        CommunitySettingsModalModel,
        CommunityJoinModalNotifier
    ],
    directives: [
        CommunityComponent,
    ],
    routes: [
        {
            name: 'CommunityRoot',
            path: '/community/...',
            component: CommunityRootRoute
        },
    ]
});