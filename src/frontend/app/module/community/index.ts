import {Component} from "angular2/core";

import {CommunityRESTService} from "./service/CommunityRESTService";
import {CommunityRouteModal} from "./component/Modal/CommunityRouteModal/index";
import {CommunityCreateModal} from "./component/Modal/CommunityCreateModal/index";
import {CommunityJoinModal} from "./component/Modal/CommunityJoinModal/index";
import {CommunityComponentService} from "./service";
import {CommunitySettingsModal} from "./component/Modal/CommunitySettingsModal/index";

@Component({
    selector: 'cass-community',
    template: require('./template.html'),
    directives: [
        CommunityRouteModal,
        CommunityCreateModal,
        CommunityJoinModal,
        CommunitySettingsModal
    ]
})
export class CommunityComponent
{
    constructor(private service: CommunityComponentService) {
        service.modals.settings.open();
    }
}