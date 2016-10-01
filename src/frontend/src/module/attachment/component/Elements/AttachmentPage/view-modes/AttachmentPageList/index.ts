import {Component, Output, Input, EventEmitter, OnChanges} from "@angular/core";

import {PageAttachmentMetadata} from "../../../../../definitions/entity/metadata/PageAttachmentMetadata";
import {AttachmentEntity} from "../../../../../definitions/entity/AttachmentEntity";
import {AttachmentLinkPageHelper} from "../../helper";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";

@Component({
    selector: 'cass-attachment-page-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class AttachmentPageList implements OnChanges
{
    @Input('attachment') attachment: AttachmentEntity<PageAttachmentMetadata>;
    @Input('viewMode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('open') openEvent: EventEmitter<AttachmentEntity<PageAttachmentMetadata>> = new EventEmitter<AttachmentEntity<PageAttachmentMetadata>>();

    private helper: AttachmentLinkPageHelper;

    ngOnChanges() {
        this.helper = new AttachmentLinkPageHelper(this.attachment);
    }

    open(attachment: AttachmentEntity<PageAttachmentMetadata>): boolean {
        this.openEvent.emit(attachment);

        return false;
    }
}