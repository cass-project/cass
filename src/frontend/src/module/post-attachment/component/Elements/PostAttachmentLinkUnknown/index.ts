import {Component, Input} from "angular2/core";

import {LinkAttachment} from "../../../definitions/entity/attachment/LinkAttachment";
import {PostAttachmentEntity} from "../../../definitions/entity/PostAttachment";
import {PageLinkMetadata} from "../../../definitions/entity/attachment/link/PageLinkMetaData";
import {UnknownLinkMetadata} from "../../../definitions/entity/attachment/link/UnknownLinkMetadata";

@Component({
    selector: 'cass-post-attachment-link-unknown',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
})
export class PostAttachmentLinkUnknown
{
    @Input('attachment') link: PostAttachmentEntity<LinkAttachment<UnknownLinkMetadata>>;
    
    getURL(): string {
        return this.link.attachment.url;
    }
}