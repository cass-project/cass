import {Component, Input, EventEmitter, Output} from "@angular/core";

import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {CommunityImage} from "../CommunityImage/index";
import {CommunityRouteService} from "../../../route/CommunityRoute/service";
import {CommunityModals} from "../../../modals";
import {CommunityRouteService} from "../../../route/CommunityRoute/service";
import {CommunityExtendedEntity} from "../../../definitions/entity/Community";

@Component({
    selector: 'cass-community-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        CommunityImage
    ]
})
export class CommunityHeader
{
    @Output('go-community') goCommunityEvent: EventEmitter<string> = new EventEmitter<string>();
    @Output('go-collection') goCollectionEvent: EventEmitter<string> = new EventEmitter<string>();

    @Input('community') entity: CommunityExtendedEntity;

    constructor(private modals: CommunityModals, private service: CommunityRouteService) {}
    
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