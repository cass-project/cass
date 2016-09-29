import {Component, Input, OnInit} from "@angular/core";

import {CommunityModals} from "../Community/modals";
import {CommunityExtendedEntity} from "../../../definitions/entity/CommunityExtended";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {BackdropType} from "../../../../backdrop/definitions/Backdrop";
import {BackdropColorMetadata} from "../../../../backdrop/definitions/metadata/BackdropColorMetadata";
import {BackdropPresetMetadata} from "../../../../backdrop/definitions/metadata/BackdropPresetMetadata";
import {BackdropUploadMetadata} from "../../../../backdrop/definitions/metadata/BackdropUploadMetadata";
import {getBackdropTextColor} from "../../../../backdrop/functions/getBackdropTextColor";

@Component({
    selector: 'cass-community-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityHeader implements OnInit
{
    @Input('community') community: CommunityExtendedEntity;

    private textColor: string;

    constructor(private modals: CommunityModals) {}

    ngOnInit(): void {
        this.textColor = getBackdropTextColor(this.community.community.backdrop);
    }

    getImageURL(): string {
        return queryImage(QueryTarget.Card, this.community.community.image).public_path;
    }

    isOwnCommunity(): boolean {
        return this.community.is_own;
    }

    changeCover() {
        this.modals.backdrop.open();
    }

    isFixed(): boolean {
        return false;
    }
}