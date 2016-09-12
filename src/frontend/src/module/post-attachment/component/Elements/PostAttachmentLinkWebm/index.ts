import {Component, Input, Directive} from "@angular/core";

import {PostAttachmentEntity} from "../../../definitions/entity/PostAttachment";
import {WebmAttachmentMetadata} from "../../../definitions/entity/metadata/WebmAttachmentMetadata";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
})
@Directive({selector: 'cass-post-attachment-link-webm'})

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