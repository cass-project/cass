import {Component, Input, ViewChild, ElementRef} from "@angular/core";

import {PostAttachmentEntity} from "../../../definitions/entity/PostAttachment";
import {YoutubeAttachmentMetadata} from "../../../definitions/entity/metadata/YoutubeAttachmentMetadata";

@Component({
    selector: 'cass-post-attachment-link-youtube',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class PostAttachmentLinkYouTube
{
    private preview: boolean = true;
    
    static DEFAULT_ORIG_WIDTH = 1280;
    static DEFAULT_ORIG_HEIGHT = 720;

    @Input('attachment') attachment: PostAttachmentEntity<YoutubeAttachmentMetadata>;
    @ViewChild('container') container: ElementRef;

    getURL(): string {
        let ogMetadata = this.attachment.link.metadata.og.og.videos;

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

        return `http://youtube.com/embed/${this.attachment.link.metadata.youtubeId}?&autoplay=1`;
    }

    getOrigWidth(): number {
        let ogMetadata = this.attachment.link.metadata.og.og.videos;

        if(ogMetadata.length) {
            let ogWidth = parseInt(ogMetadata[0]['og:width'], 10);

            if(ogWidth > 0) {
                return ogWidth;
            }
        }

        return PostAttachmentLinkYouTube.DEFAULT_ORIG_WIDTH;
    }

    getOrigHeight(): number {
        let ogMetadata = this.attachment.link.metadata.og.og.videos;

        if(ogMetadata.length) {
            let ogHeight = parseInt(ogMetadata[0]['og:height'], 10);

            if(ogHeight > 0) {
                return ogHeight;
            }
        }

        return PostAttachmentLinkYouTube.DEFAULT_ORIG_HEIGHT;
    }

    getPreviewImageURL(): string {
        if(this.attachment.link.metadata.og.og.images.length > 0) {
            let imageURL = this.attachment.link.metadata.og.og.images[0]['og:image:url'];

            if(imageURL.length) {
                return imageURL;
            }
        }

        return `http://img.youtube.com/vi/${this.attachment.link.metadata.youtubeId}/hqdefault.jpg`;
    }
    
    disablePreview() {
        this.preview = false;
    }
}