import {Component, Input, EventEmitter, Output} from "@angular/core";

import {ProfileExtendedEntity} from "../../../definitions/entity/Profile";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {ProfileImage} from "../ProfileImage/index";
import {ROUTER_DIRECTIVES} from '@angular/router';
import {ProfileModals} from "../../../modals";
import {ProfileRouteService} from "../../../route/ProfileRoute/service";

@Component({
    selector: 'cass-profile-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileImage,
        ROUTER_DIRECTIVES,
    ]
})
export class ProfileHeader
{
    @Output('go-profile') goProfileEvent: EventEmitter<string> = new EventEmitter<string>();
    @Output('go-collection') goCollectionEvent: EventEmitter<string> = new EventEmitter<string>();

    @Input('profile') entity: ProfileExtendedEntity;

    constructor(private modals: ProfileModals, private service: ProfileRouteService) {}
    
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