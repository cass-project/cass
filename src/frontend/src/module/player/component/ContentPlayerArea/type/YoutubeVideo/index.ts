import {Component, Input, OnInit} from "@angular/core";

import {AttachmentEntity} from "../../../../../attachment/definitions/entity/AttachmentEntity";
import {YoutubeAttachmentMetadata} from "../../../../../attachment/definitions/entity/metadata/YoutubeAttachmentMetadata";
import {ContentPlayerNotifier} from "../../../../service/ContentPlayerService/notify";

@Component({
    selector: 'cass-content-player-area-video-youtube',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class ContentPlayerAreaYoutubeVideo implements OnInit
{
    @Input('current') current: AttachmentEntity<YoutubeAttachmentMetadata>;

    constructor(private notify: ContentPlayerNotifier) {}

    ngOnInit() {
        this.notify.notifyAppAboutNewOpenedAttachment(this.current);
    }

    getURL(): string {
        let ogMetadata = this.current.link.metadata.og.og.videos;

        if(ogMetadata.length) {
            let ogURL = ogMetadata[0]['og:video:url'];

            if(ogURL.length) {
                var url = require('url');
                var parsed = url.parse(ogURL, false);

                if(parsed.search) {
                    if(!~parsed.search.indexOf('autoplay=1')) {
                        parsed.search = parsed.search + '&autoplay=1';
                    }
                }else{
                    parsed.search = '?autoplay=1';
                }

                return url.format(parsed);
            }
        }

        return `http://youtube.com/embed/${this.current.link.metadata.youtubeId}?&autoplay=1`;
    }
}