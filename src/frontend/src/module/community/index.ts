import {Component} from "@angular/core";
import {Router} from '@angular/router';

import {CommunityModalService} from "./service/CommunityModalService";
import {CommunityExtendedEntity} from "./definitions/entity/CommunityExtended";

@Component({
    selector: 'cass-community',
    template: require('./template.jade')
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