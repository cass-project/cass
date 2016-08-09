import {Component, Input} from "@angular/core";

import {LinkAttachment} from "../../../definitions/entity/attachment/LinkAttachment";
import {PostAttachmentEntity} from "../../../definitions/entity/PostAttachment";
import {PageLinkMetadata} from "../../../definitions/entity/attachment/link/PageLinkMetaData";
import {UnknownLinkMetadata} from "../../../definitions/entity/attachment/link/UnknownLinkMetadata";
import {WebmLinkMetadata} from "../../../definitions/entity/attachment/link/WebmLinkMetadata";

@Component({
    selector: 'cass-post-attachment-link-webm',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
})
export class PostAttachmentLinkWebm
{
    @Input('attachment') link: PostAttachmentEntity<LinkAttachment<WebmLinkMetadata>>;
    
    getType(): string {
        return this.link.attachment.metadata.type;
    }

    getURL(): string {
        return this.link.attachment.url;
    }
}