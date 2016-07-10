import {Component, Input} from "angular2/core";

import {PostAttachmentLink} from "../PostAttachmentLink/index";
import {PostAttachmentFile} from "../PostAttachmentFile/index";
import {PostAttachmentEntity} from "../../../definitions/entity/PostAttachment";

@Component({
    selector: 'cass-post-attachment',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        PostAttachmentLink,
        PostAttachmentFile,
    ]
})
export class PostAttachment 
{
    @Input('attachment') attachment: PostAttachmentEntity<any>;

    is(attachmentType: string) {
        return this.attachment.attachment_type === attachmentType;
    }
}