import {Component, Input, Directive} from "@angular/core";

import {PostAttachmentEntity, AttachmentMetadata} from "../../../definitions/entity/PostAttachment";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-post-attachment'})

export class PostAttachment
{
    @Input('attachment') attachment: PostAttachmentEntity<AttachmentMetadata>;
    
    is(resource: string) {
        return this.attachment.link.resource === resource;
    }
}