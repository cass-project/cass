import {Component, Input, ViewChild, ElementRef} from "@angular/core";

import {PostAttachmentEntity} from "../../../definitions/entity/PostAttachment";
import {ImageAttachmentMetadata} from "../../../definitions/entity/metadata/ImageAttachmentMetadata";

@Component({
    selector: 'cass-post-attachment-link-image',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
})
export class PostAttachmentLinkImage
{
    @Input('attachment') attachment: PostAttachmentEntity<ImageAttachmentMetadata>;

    getImageURL(): string {
        return this.attachment.link.url;
    }
}