import {Component, OnChanges, Input, Output, EventEmitter} from "@angular/core";

import {ImageAttachmentMetadata} from "../../../../../definitions/entity/metadata/ImageAttachmentMetadata";
import {AttachmentEntity} from "../../../../../definitions/entity/AttachmentEntity";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {AttachmentImageHelper} from "../../helper";

@Component({
    selector: 'cass-attachment-image-grid',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class AttachmentImageGrid implements OnChanges
{
    @Input('attachment') attachment: AttachmentEntity<ImageAttachmentMetadata>;
    @Output('open') openEvent: EventEmitter<AttachmentEntity<ImageAttachmentMetadata>> = new EventEmitter<AttachmentEntity<ImageAttachmentMetadata>>();

    private viewMode: ViewOptionValue = ViewOptionValue.Grid;
    private helper: AttachmentImageHelper;

    ngOnChanges() {
        this.helper = new AttachmentImageHelper(this.attachment);
    }

    open(attachment: AttachmentEntity<ImageAttachmentMetadata>): boolean {
        this.openEvent.emit(attachment);

        return false;
    }
}