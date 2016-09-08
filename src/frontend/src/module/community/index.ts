import {Component} from "@angular/core";
import {Router} from '@angular/router';

import {CommunityRouteModal} from "./component/Modal/CommunityRouteModal";
import {CommunityCreateModal} from "./component/Modal/CommunityCreateModal";
import {CommunityJoinModal} from "./component/Modal/CommunityJoinModal";
import {CommunitySettingsModal} from "./component/Modal/CommunitySettingsModal";
import {CommunityModalService} from "./service/CommunityModalService";
import {CommunityExtendedEntity} from "./definitions/entity/CommunityExtended";

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
    constructor(
        private service: CommunityModalService,
        private router: Router
    ) {}

    goCommunity(entity: CommunityExtendedEntity) {
        this.router.navigate(['Community', 'Community', { sid: entity.community.sid }]);
    }
}