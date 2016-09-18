import {Component, Input} from "@angular/core";
import {AttachmentEntity} from "../../../definitions/entity/AttachmentEntity";
import {ImageAttachmentMetadata} from "../../../definitions/entity/metadata/ImageAttachmentMetadata";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector:  'cass-post-attachment-link-image'})

export class AttachmentLinkImage
{
    @Input('attachment') attachment: AttachmentEntity<ImageAttachmentMetadata>;

    getImageURL(): string {
        return this.attachment.link.url;
    }
}