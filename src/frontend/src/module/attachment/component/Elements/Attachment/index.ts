import {Component, Input, Output, EventEmitter} from "@angular/core";

import {AttachmentEntity, AttachmentMetadata} from "../../../definitions/entity/AttachmentEntity";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";

@Component({
    selector: 'cass-attachment',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class Attachment
{
    @Input('attachment') attachment: AttachmentEntity<AttachmentMetadata>;
    @Input('viewMode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('open') openEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();

    is(resource: string) {
        return this.attachment.link.resource === resource;
    }

    open(attachment: AttachmentEntity<any>) {
        this.openEvent.emit(attachment);
    }
}