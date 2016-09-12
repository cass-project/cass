import {Component, Input} from "@angular/core";

import {PostAttachmentEntity} from "../../../definitions/entity/PostAttachment";
import {UnknownAttachmentMetadata} from "../../../definitions/entity/metadata/UnknownAttachmentMetadata";

@Component({
    selector: 'cass-post-attachment-link-unknown',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
})
export class PostAttachmentLinkUnknown
{
    @Input('attachment') attachment: PostAttachmentEntity<UnknownAttachmentMetadata>;
    
    getURL(): string {
        return this.attachment.link.url
    }
}