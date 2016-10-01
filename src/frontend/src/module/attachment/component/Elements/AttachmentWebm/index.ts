import {Component, Input, Output, EventEmitter} from "@angular/core";

import {AttachmentEntity} from "../../../definitions/entity/AttachmentEntity";
import {WebmAttachmentMetadata} from "../../../definitions/entity/metadata/WebmAttachmentMetadata";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {AttachmentWebmFeed} from "./view-modes/AttachmentWebmFeed/index";
import {AttachmentWebmGrid} from "./view-modes/AttachmentWebmGrid/index";
import {AttachmentWebmList} from "./view-modes/AttachmentWebmList/index";

@Component({
    selector: 'cass-attachment-webm',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class AttachmentWebm
{
    @Input('attachment') attachment: AttachmentEntity<WebmAttachmentMetadata>;
    @Input('viewMode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('open') openEvent: EventEmitter<AttachmentEntity<WebmAttachmentMetadata>> = new EventEmitter<AttachmentEntity<WebmAttachmentMetadata>>();

    isViewMode(viewMode: ViewOptionValue): boolean {
        return viewMode === this.viewMode;
    }

    open(attachment: AttachmentEntity<WebmAttachmentMetadata>): boolean {
        this.openEvent.emit(attachment);

        return false;
    }
}

export const ATTACHMENT_WEBM_DIRECTIVES = [
    AttachmentWebm,
    AttachmentWebmFeed,
    AttachmentWebmGrid,
    AttachmentWebmList,
];

export interface AttachmentWebmFeatures {
    cover: boolean;
}

export const FeaturesByVersion: {[version: number]: AttachmentWebmFeatures} = {
    1: {
        cover: false
    },
    2: {
        cover: true
    }
};