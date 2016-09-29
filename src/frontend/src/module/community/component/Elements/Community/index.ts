import {Component} from "@angular/core";
import {Router} from "@angular/router";

import {CommunityModalService} from "../../../service/CommunityModalService";
import {CommunityExtendedEntity} from "../../../definitions/entity/CommunityExtended";
import {CollectionEntity} from "../../../../collection/definitions/entity/collection";
import {CommunityModals} from "./modals";

@Component({
    selector: 'cass-community',
    template: require('./template.jade'),
})
export class CommunityComponent
{
    constructor(
        private service: CommunityModalService,
        private router: Router,
        private modals: CommunityModals
    ) {}

    goCollection(entity: CommunityExtendedEntity, collection: CollectionEntity) {
        this.router.navigate(['/profile', entity.community.sid, collection.sid]);
    }

    goCommunity(entity: CommunityExtendedEntity) {
        this.router.navigate(['/community', entity.community.sid]);
    }
}