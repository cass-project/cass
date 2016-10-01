import {AttachmentEntity} from "../../../definitions/entity/AttachmentEntity";
import {YoutubeAttachmentMetadata} from "../../../definitions/entity/metadata/YoutubeAttachmentMetadata";
import {AttachmentYouTube} from "./index";

export class AttachmentYoutubeHelper
{
    public preview: boolean = true;

    constructor(
        public attachment: AttachmentEntity<YoutubeAttachmentMetadata>
    ) {}

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

        return AttachmentYouTube.DEFAULT_ORIG_WIDTH;
    }

    getOrigHeight(): number {
        let ogMetadata = this.attachment.link.metadata.og.og.videos;

        if(ogMetadata.length) {
            let ogHeight = parseInt(ogMetadata[0]['og:height'], 10);

            if(ogHeight > 0) {
                return ogHeight;
            }
        }

        return AttachmentYouTube.DEFAULT_ORIG_HEIGHT;
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

    enablePreview() {
        this.preview = true;
    }

    disablePreview() {
        this.preview = false;
    }
}