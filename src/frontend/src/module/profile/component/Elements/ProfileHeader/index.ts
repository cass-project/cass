import {Component, Input, OnInit} from "@angular/core";

import {ProfileExtendedEntity} from "../../../definitions/entity/Profile";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {ProfileModals} from "../Profile/modals";
import {BackdropType} from "../../../../backdrop/definitions/Backdrop";
import {BackdropColorMetadata} from "../../../../backdrop/definitions/metadata/BackdropColorMetadata";
import {BackdropPresetMetadata} from "../../../../backdrop/definitions/metadata/BackdropPresetMetadata";
import {BackdropUploadMetadata} from "../../../../backdrop/definitions/metadata/BackdropUploadMetadata";
import {getBackdropTextColor} from "../../../../backdrop/functions/getBackdropTextColor";

@Component({
    selector: 'cass-profile-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileHeader implements OnInit
{
    @Input('profile') profile: ProfileExtendedEntity;

    private textColor: string;

    constructor(private modals: ProfileModals) {}

    ngOnInit(): void {
        this.textColor = getBackdropTextColor(this.profile.profile.backdrop);
    }

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