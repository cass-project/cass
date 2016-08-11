import {Component} from "@angular/core";
import {Router} from "@angular/router-deprecated";

import {CommunityRouteModal} from "./component/Modal/CommunityRouteModal";
import {CommunityJoinModal} from "./component/Modal/CommunityJoinModal";
import {CommunityCreateModal} from "./component/Modal/CommunityCreateModal";
import {CommunitySettingsModal} from "./component/Modal/CommunitySettingsModal";
import {CommunityModalService} from "./service/CommunityModalService";
import {CommunityExtendedEntity} from "./definitions/entity/CommunityExtended";

@Component({
    selector: 'cass-community',
    template: require('./template.jade'),
    directives: [
        CommunityRouteModal,
        CommunityJoinModal,
        CommunityCreateModal,
        CommunitySettingsModal
    ]
})
export class CommunityComponent
{
    constructor(
        private modals: CommunityModalService,
        private router: Router
    ) {}

    goCommunity(entity: CommunityExtendedEntity) {
        this.router.navigate(['CommunityRoot', 'Community', { sid: entity.community.sid }]);
    }
}