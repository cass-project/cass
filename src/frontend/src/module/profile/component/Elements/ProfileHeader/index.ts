import {Component, Input} from "@angular/core";

import {ProfileExtendedEntity} from "../../../definitions/entity/Profile";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {ProfileModals} from "../Profile/modals";

@Component({
    selector: 'cass-profile-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileHeader
{
    @Input('profile') profile: ProfileExtendedEntity;

    constructor(private modals: ProfileModals) {}

    getImageURL(): string {
        return queryImage(QueryTarget.Card, this.profile.profile.image).public_path;
    }

    isOwnProfile(): boolean {
        return this.profile.is_own;
    }

    changeCover() {
        this.modals.backdrop.open();
    }

    isFixed(): boolean {
        return false;
    }
}