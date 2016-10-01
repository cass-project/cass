import {Component, Input, Output, EventEmitter} from "@angular/core";

import {AttachmentEntity} from "../../../../../attachment/definitions/entity/AttachmentEntity";
import {YoutubeAttachmentMetadata} from "../../../../../attachment/definitions/entity/metadata/YoutubeAttachmentMetadata";
import {basename} from "../../../../../common/functions/basename";
import moment = require("moment");

@Component({
    selector: 'cass-content-player-playlist-item-youtube',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class YoutubeItem
{
    @Input('is-current') isCurrent: boolean;
    @Input('attachment') attachment: AttachmentEntity<YoutubeAttachmentMetadata>;
    @Output('play') playEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();

    getPreview(): string {
        if(this.attachment.link.metadata.og.og.images.length > 0) {
            let imageURL = this.attachment.link.metadata.og.og.images[0]['og:image:url'];

            if(imageURL.length) {
                return imageURL;
            }
        }

        return `http://img.youtube.com/vi/${this.attachment.link.metadata.youtubeId}/hqdefault.jpg`;
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