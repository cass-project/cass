import {Component} from "angular2/core";

import {CommunityRouteModal} from "./component/Modal/CommunityRouteModal";
import {CommunityCreateModal} from "./component/Modal/CommunityCreateModal";
import {CommunityJoinModal} from "./component/Modal/CommunityJoinModal";
import {CommunitySettingsModal} from "./component/Modal/CommunitySettingsModal";
import {CommunityModalService} from "./service/CommunityModalService";

@Component({
    selector: 'cass-community',
    template: require('./template.jade'),
    directives: [
        CommunityRouteModal,
        CommunityCreateModal,
        CommunityJoinModal,
        CommunitySettingsModal
    ]
})
export class CommunityComponent
{
    constructor(private service: CommunityModalService) {}
}