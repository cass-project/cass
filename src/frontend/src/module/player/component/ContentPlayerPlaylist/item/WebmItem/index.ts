import {Component, Input, Output, EventEmitter} from "@angular/core";

import {AttachmentEntity} from "../../../../../attachment/definitions/entity/AttachmentEntity";
import {WebmAttachmentMetadata} from "../../../../../attachment/definitions/entity/metadata/WebmAttachmentMetadata";
import {basename} from "../../../../../common/functions/basename";
import moment = require("moment");

@Component({
    selector: 'cass-content-player-playlist-item-webm',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class WebmItem
{
    @Input('is-current') isCurrent: boolean;
    @Input('attachment') attachment: AttachmentEntity<WebmAttachmentMetadata>;
    @Output('play') playEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();

    getPreview(): string {
        return this.attachment.link.metadata.preview.public;
    }

    getTitle(): string {
        return basename(this.attachment.link.url);
    }

    getDate(): string {
        return moment(this.attachment.date_created_on).format();
    }

    play() {
        this.playEvent.emit(this.attachment);
    }
}