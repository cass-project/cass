import {Component, Input} from "@angular/core";

import {PostAttachmentEntity} from "../../../definitions/entity/PostAttachment";
import {WebmAttachmentMetadata} from "../../../definitions/entity/metadata/WebmAttachmentMetadata";

@Component({
    selector: 'cass-post-attachment-link-webm',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
})
export class PostAttachmentLinkWebm
{
    @Input('attachment') attachment: PostAttachmentEntity<WebmAttachmentMetadata>;
    
    getType(): string {
        return this.attachment.link.metadata.type;
    }

    getURL(): string {
        return this.attachment.link.url;
    }
}