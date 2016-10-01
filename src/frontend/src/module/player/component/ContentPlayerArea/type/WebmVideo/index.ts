import {Component, Input, OnInit} from "@angular/core";

import {AttachmentEntity} from "../../../../../attachment/definitions/entity/AttachmentEntity";
import {WebmAttachmentMetadata} from "../../../../../attachment/definitions/entity/metadata/WebmAttachmentMetadata";
import {ContentPlayerNotifier} from "../../../../service/ContentPlayerService/notify";

@Component({
    selector: 'cass-content-player-area-video-webm',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class ContentPlayerAreaWebmVideo implements OnInit
{
    @Input('current') current: AttachmentEntity<WebmAttachmentMetadata>;

    constructor(private notify: ContentPlayerNotifier) {}

    ngOnInit() {
        this.notify.notifyAppAboutNewOpenedAttachment(this.current);
    }

    getType(): string {
        return this.current.link.metadata.type;
    }

    getURL(): string {
        return this.current.link.url;
    }

    getCover(): string {
        return this.current.link.metadata.preview.public;
    }
}