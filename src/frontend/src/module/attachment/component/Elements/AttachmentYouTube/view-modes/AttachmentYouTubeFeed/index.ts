import {Component, OnChanges, Input, Output, EventEmitter, ViewChild, ElementRef} from "@angular/core";

import {AttachmentEntity} from "../../../../../definitions/entity/AttachmentEntity";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {AttachmentYoutubeHelper} from "../../helper";
import {YoutubeAttachmentMetadata} from "../../../../../definitions/entity/metadata/YoutubeAttachmentMetadata";

@Component({
    selector: 'cass-attachment-youtube-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class AttachmentYouTubeFeed implements OnChanges
{
    @Input('attachment') attachment: AttachmentEntity<YoutubeAttachmentMetadata>;
    @Output('open') openEvent: EventEmitter<AttachmentEntity<YoutubeAttachmentMetadata>> = new EventEmitter<AttachmentEntity<YoutubeAttachmentMetadata>>();

    private viewMode: ViewOptionValue = ViewOptionValue.Feed;
    private helper: AttachmentYoutubeHelper;

    ngOnChanges() {
        this.helper = new AttachmentYoutubeHelper(this.attachment);
    }

    open(attachment: AttachmentEntity<YoutubeAttachmentMetadata>): boolean {
        this.openEvent.emit(attachment);

        return false;
    }
}