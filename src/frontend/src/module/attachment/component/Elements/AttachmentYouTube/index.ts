import {Component, Input, Output, EventEmitter} from "@angular/core";

import {AttachmentEntity} from "../../../definitions/entity/AttachmentEntity";
import {YoutubeAttachmentMetadata} from "../../../definitions/entity/metadata/YoutubeAttachmentMetadata";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {AttachmentYouTubeFeed} from "./view-modes/AttachmentYouTubeFeed/index";
import {AttachmentYouTubeGrid} from "./view-modes/AttachmentYoutubeGrid/index";
import {AttachmentYouTubeList} from "./view-modes/AttachmentYouTubeList/index";

@Component({
    selector: 'cass-attachment-youtube',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class AttachmentYouTube
{
    static DEFAULT_ORIG_WIDTH = 1280;
    static DEFAULT_ORIG_HEIGHT = 720;

    @Input('attachment') attachment: AttachmentEntity<YoutubeAttachmentMetadata>;
    @Input('view-mode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('open') openEvent: EventEmitter<AttachmentEntity<YoutubeAttachmentMetadata>> = new EventEmitter<AttachmentEntity<YoutubeAttachmentMetadata>>();

    isViewMode(viewMode: ViewOptionValue): boolean {
        return viewMode === this.viewMode;
    }

    open(attachment: AttachmentEntity<YoutubeAttachmentMetadata>): boolean {
        this.openEvent.emit(attachment);

        return false;
    }
}

export const ATTACHMENT_YOUTUBE_DIRECTIVES = [
    AttachmentYouTube,
    AttachmentYouTubeFeed,
    AttachmentYouTubeGrid,
    AttachmentYouTubeList,
];