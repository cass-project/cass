import {Component, Input} from "angular2/core";

import {LinkAttachment} from "../../../definitions/entity/attachment/LinkAttachment";
import {PostAttachmentEntity} from "../../../definitions/entity/PostAttachment";
import {PostAttachmentLinkYouTube} from "../PostAttachmentLinkYouTube/index";
import {PostAttachmentLinkImage} from "../PostAttachmentLinkImage/index";
import {PostAttachmentLinkPage} from "../PostAttachmentLinkPage/index";

@Component({
    selector: 'cass-post-attachment-link',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        PostAttachmentLinkYouTube,
        PostAttachmentLinkImage,
        PostAttachmentLinkPage,
    ]
})
export class PostAttachmentLink
{
    @Input('attachment') link: PostAttachmentEntity<LinkAttachment<any>>;
    
    is(resource: string) {
        return this.link.attachment.resource === resource;
    }
}