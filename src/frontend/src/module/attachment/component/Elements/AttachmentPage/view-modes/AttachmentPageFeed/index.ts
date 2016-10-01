import {Component, Output, Input, EventEmitter, OnChanges} from "@angular/core";

import {PageAttachmentMetadata} from "../../../../../definitions/entity/metadata/PageAttachmentMetadata";
import {AttachmentEntity} from "../../../../../definitions/entity/AttachmentEntity";
import {AttachmentLinkPageHelper} from "../../helper";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";

@Component({
    selector: 'cass-attachment-page-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class AttachmentPageFeed implements OnChanges
{
    @Input('attachment') attachment: AttachmentEntity<PageAttachmentMetadata>;
    @Output('open') openEvent: EventEmitter<AttachmentEntity<PageAttachmentMetadata>> = new EventEmitter<AttachmentEntity<PageAttachmentMetadata>>();

    private viewMode: ViewOptionValue = ViewOptionValue.Feed;
    private helper: AttachmentLinkPageHelper;

    ngOnChanges() {
        this.helper = new AttachmentLinkPageHelper(this.attachment);
    }

    open(attachment: AttachmentEntity<PageAttachmentMetadata>) {
        return this.openEvent.emit(attachment);
    }
}