import {Component, Input, Directive} from "@angular/core";

import {PostAttachmentEntity} from "../../../definitions/entity/PostAttachment";
import {UnknownAttachmentMetadata} from "../../../definitions/entity/metadata/UnknownAttachmentMetadata";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector:  'cass-post-attachment-link-unknown'})

export class PostAttachmentLinkUnknown
{
    @Input('attachment') attachment: PostAttachmentEntity<UnknownAttachmentMetadata>;
    
    getURL(): string {
        return this.attachment.link.url
    }
}