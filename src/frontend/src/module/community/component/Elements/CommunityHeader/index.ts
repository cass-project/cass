import {Component, Input, EventEmitter, Output} from "@angular/core";

import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {CommunityRouteService} from "../../../route/CommunityRoute/service";
import {CommunityModals} from "../Community/modals";
import {CommunityExtendedEntity} from "../../../definitions/entity/CommunityExtended";

@Component({
    selector: 'cass-community-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityHeader
{
    constructor(
        private modals: CommunityModals,
        private service: CommunityRouteService
    ) {}

    @Output('go-community') goCommunityEvent: EventEmitter<string> = new EventEmitter<string>();
    @Output('go-collection') goCollectionEvent: EventEmitter<string> = new EventEmitter<string>();

    @Input('community') entity: CommunityExtendedEntity;
    
    getCommunityTitle(): string {
        return this.entity.community.title;
    }

    getImageURL(): string {
        return queryImage(QueryTarget.Avatar, this.entity.community.image).public_path;
    }
    
    goCommunity() {
        this.goCommunityEvent.emit('go-community');
    }
    
    goCollection(sid: string) {
        this.goCollectionEvent.emit(sid);
    }

    isOwnCommunity(): boolean {
        return this.entity.is_own;
    }
}