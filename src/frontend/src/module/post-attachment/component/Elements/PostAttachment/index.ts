import {Component, Input} from "@angular/core";

import {PostAttachmentEntity, AttachmentMetadata} from "../../../definitions/entity/PostAttachment";

@Component({
    selector: 'cass-post-attachment',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class PostAttachment
{
    @Input('attachment') attachment: PostAttachmentEntity<AttachmentMetadata>;
    
    is(resource: string) {
        return this.attachment.link.resource === resource;
    }
}