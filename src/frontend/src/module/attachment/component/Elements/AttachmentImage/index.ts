import {Component, Input, Output, EventEmitter} from "@angular/core";

import {AttachmentEntity} from "../../../definitions/entity/AttachmentEntity";
import {ImageAttachmentMetadata} from "../../../definitions/entity/metadata/ImageAttachmentMetadata";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {AttachmentImageFeed} from "./view-modes/AttachmentImageFeed/index";
import {AttachmentImageGrid} from "./view-modes/AttachmentImageGrid/index";
import {AttachmentImageList} from "./view-modes/AttachmentImageList/index";

@Component({
    selector:  'cass-attachment-image',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class AttachmentImage
{
    @Input('attachment') attachment: AttachmentEntity<ImageAttachmentMetadata>;

    @Input('attachment') attachment: AttachmentEntity<ImageAttachmentMetadata>;
    @Input('viewMode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('open') openEvent: EventEmitter<AttachmentEntity<ImageAttachmentMetadata>> = new EventEmitter<AttachmentEntity<ImageAttachmentMetadata>>();

    isViewMode(viewMode: ViewOptionValue): boolean {
        return viewMode === this.viewMode;
    }

    open(attachment: AttachmentEntity<ImageAttachmentMetadata>): boolean {
        this.openEvent.emit(attachment);

        return false;
    }
}

export const ATTACHMENT_IMAGE_DIRECTIVES = [
    AttachmentImage,
    AttachmentImageFeed,
    AttachmentImageGrid,
    AttachmentImageList,
];