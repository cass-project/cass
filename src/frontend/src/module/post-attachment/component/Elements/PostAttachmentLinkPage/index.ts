import {Component, Input} from "angular2/core";

import {LinkAttachment} from "../../../definitions/entity/attachment/LinkAttachment";
import {PostAttachmentEntity} from "../../../definitions/entity/PostAttachment";
import {PageLinkMetadata} from "../../../definitions/entity/attachment/link/PageLinkMetaData";
import {AttachmentError} from "../Error/index";

/**
 * Каждый метод должен содержать try-catch блок
 * Если во время исполнения произошла ошибка, то аттачмент должен помечатся как "invalid", т.е. невозможный к отображению
 */

@Component({
    selector: 'cass-post-attachment-link-page',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        AttachmentError,
    ]
})
export class PostAttachmentLinkPage
{
    @Input('attachment') link: PostAttachmentEntity<LinkAttachment<PageLinkMetadata>>;

    private markedAsError: boolean = false;
    
    isValid(): boolean {
        if(this.markedAsError) {
            return false;
        }else{
            let hasURL = (typeof this.link.attachment.url === 'string') && this.link.attachment.url.length > 0;
            let hasOG = !! this.link.attachment.metadata.og;

            return hasURL && hasOG;
        }
    }

    getTitle(): string {
        try {
            let basic = this.link.attachment.metadata.og.basic;
            let ogBasic = this.link.attachment.metadata.og.og.basic;

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
            let basic = this.link.attachment.metadata.og.basic;
            let ogBasic = this.link.attachment.metadata.og.og.basic;

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
            let basic = this.link.attachment.metadata.og.basic;
            let ogBasic = this.link.attachment.metadata.og.og.basic;

            if(ogBasic['og:url'].length) {
                return ogBasic['og:url'];
            }else if(basic.url.length) {
                return basic.url;
            }else{
                return this.link.attachment.url;
            }
        }catch(error) {
            return '<INVALID>';
        }
    }

    hasImage(): boolean {
        try {
            return this.getImageURL().length > 0;
        }catch(error) {
            this.markedAsError = true;

            return false;
        }
    }

    getImageURL(): string {
        try {
            let basic = this.link.attachment.metadata.og.og.basic;
            let images = this.link.attachment.metadata.og.og.images;

            if(images.length) {
                return images[0]['og:image:url'];
            }else if(basic['og:image'].length) {
                return basic['og:image'];
            }else{
                return '';
            }
        }catch(error) {
            this.markedAsError = true;

            return '';
        }
    }
}