import {AttachmentEntity} from "../../../definitions/entity/AttachmentEntity";
import {PageAttachmentMetadata} from "../../../definitions/entity/metadata/PageAttachmentMetadata";

export class AttachmentLinkPageHelper
{
    public static DEFAULT_IMAGE = '/dist/assets/entity/attachment/default-web-page-image-bg.png';

    private markedAsError: boolean = false;

    constructor(
        public attachment: AttachmentEntity<PageAttachmentMetadata>
    ) {}

    isValid(): boolean {
        if(this.markedAsError) {
            return false;
        }else{
            let hasURL = (typeof this.attachment.link.url === 'string') && this.attachment.link.url.length > 0;
            let hasOG = !! this.attachment.link.metadata.og;

            return hasURL && hasOG;
        }
    }

    getTitle(): string {
        try {
            let basic = this.attachment.link.metadata.og.basic;
            let ogBasic = this.attachment.link.metadata.og.og.basic;

            if(ogBasic['og:title'].length) {
                return ogBasic['og:title'];
            }else if(basic.title.length) {
                return basic.title;
            }else{
                return this.getURL();
            }
        }catch(error) {
            this.markedAsError = true;

            return '<INVALID>';
        }
    }

    hasDescription(): boolean {
        try {
            return this.getDescription().length > 0;
        }catch(error) {
            this.markedAsError = true;

            return false;
        }
    }

    getDescription(): string {
        try {
            let basic = this.attachment.link.metadata.og.basic;
            let ogBasic = this.attachment.link.metadata.og.og.basic;

            if(ogBasic['og:description'].length) {
                return ogBasic['og:description'];
            }else if(basic.description.length) {
                return basic.description;
            }else{
                return '';
            }
        }catch(error) {
            this.markedAsError = true;

            return '<INVALID>';
        }
    }

    getURL(): string {
        try {
            let basic = this.attachment.link.metadata.og.basic;
            let ogBasic = this.attachment.link.metadata.og.og.basic;

            if(ogBasic['og:url'].length) {
                return ogBasic['og:url'];
            }else if(basic.url.length) {
                return basic.url;
            }else{
                return this.attachment.link.url;
            }
        }catch(error) {
            return '<INVALID>';
        }
    }

    hasImage(): boolean {
        let basic = this.attachment.link.metadata.og.og.basic;
        let images = this.attachment.link.metadata.og.og.images;

        return images.length > 0 || basic['og:image'].length.length > 0;
    }

    getImageURL(): string {
        if(this.hasImage()) {
            let result = (() => {
                let basic = this.attachment.link.metadata.og.og.basic;
                let images = this.attachment.link.metadata.og.og.images;

                if(images.length) {
                    return images[0]['og:image:url'];
                }else if(basic['og:image'].length) {
                    return basic['og:image'];
                }else{
                    return AttachmentLinkPageHelper.DEFAULT_IMAGE;
                }
            })();

            return typeof result === 'string'
                ? result
                : AttachmentLinkPageHelper.DEFAULT_IMAGE;
        }else{
            return AttachmentLinkPageHelper.DEFAULT_IMAGE;
        }
    }
}