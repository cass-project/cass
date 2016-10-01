import {Component, Input, Output, EventEmitter} from "@angular/core";

import {AttachmentEntity} from "../../../definitions/entity/AttachmentEntity";
import {UnknownAttachmentMetadata} from "../../../definitions/entity/metadata/UnknownAttachmentMetadata";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {AttachmentLinkFeed} from "./view-modes/AttachmentLinkFeed/index";
import {AttachmentLinkGrid} from "./view-modes/AttachmentLinkGrid/index";
import {AttachmentLinkList} from "./view-modes/AttachmentLinkList/index";

@Component({
    selector:  'cass-attachment-link',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class AttachmentLink
{
    @Input('attachment') attachment: AttachmentEntity<UnknownAttachmentMetadata>;
    @Input('view-mode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('open') openEvent: EventEmitter<AttachmentEntity<UnknownAttachmentMetadata>> = new EventEmitter<AttachmentEntity<UnknownAttachmentMetadata>>();

    isViewMode(viewMode: ViewOptionValue): boolean {
        return viewMode === this.viewMode;
    }

    open(attachment: AttachmentEntity<UnknownAttachmentMetadata>): boolean {
        this.openEvent.emit(attachment);

        return false;
    }
}

export const ATTACHMENT_LINK_DIRECTIVES = [
    AttachmentLink,
    AttachmentLinkFeed,
    AttachmentLinkGrid,
    AttachmentLinkList,
];