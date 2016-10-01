import {Component, Input, Output, EventEmitter} from "@angular/core";

import {AttachmentEntity} from "../../../definitions/entity/AttachmentEntity";
import {PageAttachmentMetadata} from "../../../definitions/entity/metadata/PageAttachmentMetadata";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {AttachmentPageFeed} from "./view-modes/AttachmentPageFeed/index";
import {AttachmentPageGrid} from "./view-modes/AttachmentPageGrid/index";
import {AttachmentPageList} from "./view-modes/AttachmentPageList/index";

@Component({
    selector: 'cass-attachment-page',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class AttachmentPage
{
    @Input('attachment') attachment: AttachmentEntity<PageAttachmentMetadata>;
    @Input('viewMode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('open') openEvent: EventEmitter<AttachmentEntity<PageAttachmentMetadata>> = new EventEmitter<AttachmentEntity<PageAttachmentMetadata>>();

    open(attachment: AttachmentEntity<PageAttachmentMetadata>): boolean {
        this.openEvent.emit(attachment);

        return false;
    }
}

export const ATTACHMENT_PAGE_DIRECTIVES = [
    AttachmentPage,
    AttachmentPageFeed,
    AttachmentPageGrid,
    AttachmentPageList,
];