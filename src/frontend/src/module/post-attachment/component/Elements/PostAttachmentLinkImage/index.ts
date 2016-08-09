import {Component, Input, ViewChild, ElementRef} from "@angular/core";

import {LinkAttachment} from "../../../definitions/entity/attachment/LinkAttachment";
import {ImageLinkMetaData} from "../../../definitions/entity/attachment/link/ImageLinkMetaData";
import {PostAttachmentEntity} from "../../../definitions/entity/PostAttachment";

@Component({
    selector: 'cass-post-attachment-link-image',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
})
export class PostAttachmentLinkImage
{
    @Input('attachment') link: PostAttachmentEntity<LinkAttachment<ImageLinkMetaData>>;

    getImageURL(): string {
        return this.link.attachment.url;
    }
}