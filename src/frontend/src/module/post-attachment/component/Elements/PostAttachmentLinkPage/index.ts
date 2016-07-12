import {Component, Input} from "angular2/core";

import {LinkAttachment} from "../../../definitions/entity/attachment/LinkAttachment";
import {PostAttachmentEntity} from "../../../definitions/entity/PostAttachment";
import {PageLinkMetadata} from "../../../definitions/entity/attachment/link/PageLinkMetaData";

@Component({
    selector: 'cass-post-attachment-link-page',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
})
export class PostAttachmentLinkPage
{
    @Input('attachment') link: PostAttachmentEntity<LinkAttachment<PageLinkMetadata>>;

    getTitle(): string {
        let basic = this.link.attachment.metadata.og.basic;
        let ogBasic = this.link.attachment.metadata.og.og.basic;

        if(ogBasic['og:title'].length) {
            return ogBasic['og:title'];
        }else if(basic.title.length) {
            return basic.title;
        }else{
            return this.getURL();
        }
    }

    hasDescription(): boolean {
        return this.getDescription().length > 0;
    }

    getDescription(): string {
        let basic = this.link.attachment.metadata.og.basic;
        let ogBasic = this.link.attachment.metadata.og.og.basic;

        if(ogBasic['og:description'].length) {
            return ogBasic['og:description'];
        }else if(basic.description.length) {
            return basic.description;
        }else{
            return '';
        }
    }

    getURL(): string {
        let basic = this.link.attachment.metadata.og.basic;
        let ogBasic = this.link.attachment.metadata.og.og.basic;

        if(ogBasic['og:url'].length) {
            return ogBasic['og:url'];
        }else if(basic.url.length) {
            return basic.url;
        }else{
            return this.link.attachment.url;
        }
    }

    hasImage(): boolean {
        return this.getImageURL().length > 0;
    }

    getImageURL(): string {
        let basic = this.link.attachment.metadata.og.og.basic;
        let images = this.link.attachment.metadata.og.og.images;

        if(images.length) {
            return images[0]['og:image:url'];
        }else if(basic['og:image'].length) {
            return basic['og:image'];
        }else{
            return '';
        }
    }
}