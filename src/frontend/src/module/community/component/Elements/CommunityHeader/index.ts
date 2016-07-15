import {Component, Input, EventEmitter, Output} from "angular2/core";

import {ProfileExtendedEntity} from "../../../definitions/entity/Profile";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {CommunityImage} from "../CommunityImage/index";
import {ROUTER_DIRECTIVES} from "angular2/router";
import {CommunityRouteService} from "../../../route/CommunityRoute/service";
import {CommunityModals} from "../../../modals";
import {CommunityRouteService} from "../../../route/CommunityRoute/service";

@Component({
    selector: 'cass-profile-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        CommunityImage,
        ROUTER_DIRECTIVES,
    ]
})
export class ProfileHeader
{
    @Output('go-profile') goProfileEvent: EventEmitter<string> = new EventEmitter<string>();
    @Output('go-collection') goCollectionEvent: EventEmitter<string> = new EventEmitter<string>();

    @Input('profile') entity: ProfileExtendedEntity;

    constructor(private modals: CommunityModals, private service: CommunityRouteService) {}
    
    getProfileGreetings(): string {
        return this.entity.profile.greetings.greetings;
    }

    getProfileURL(): string {
        return queryImage(QueryTarget.Avatar, this.entity.profile.image).public_path;
    }
    
    goProfile() {
        this.goProfileEvent.emit('go-profile');
    }
    
    goCollection(sid: string) {
        this.goCollectionEvent.emit(sid);
    }

    isOwnProfile(): boolean {
        return this.entity.is_own;
    }
}