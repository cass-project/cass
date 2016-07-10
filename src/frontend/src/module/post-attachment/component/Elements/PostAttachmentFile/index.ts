import {Component, Input} from "angular2/core";
import {PostAttachmentEntity} from "../../../definitions/entity/PostAttachment";

@Component({
    selector: 'cass-post-attachment-file',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        PostAttachmentFile,
    ]
})
export class PostAttachmentFile
{
    @Input('attachment') attachment: PostAttachmentEntity<any>;

    is(code: string) {
        return code === this.attachment.attachment_type;
    }
}