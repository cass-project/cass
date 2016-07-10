import {Component, Input} from "angular2/core";

import {LinkAttachment} from "../../../definitions/entity/attachment/LinkAttachment";
import {PostAttachmentEntity} from "../../../definitions/entity/PostAttachment";
import {PostAttachmentLinkYouTube} from "../PostAttachmentLinkYouTube/index";
import {PostAttachmentLinkImage} from "../PostAttachmentLinkImage/index";
import {PostAttachmentLinkPage} from "../PostAttachmentLinkPage/index";
import {PostAttachmentLinkUnknown} from "../PostAttachmentLinkUnknown/index";
import {PostAttachmentLinkWebm} from "../PostAttachmentLinkWebm/index";

@Component({
    selector: 'cass-post-attachment',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        PostAttachmentLinkYouTube,
        PostAttachmentLinkImage,
        PostAttachmentLinkPage,
        PostAttachmentLinkWebm,
        PostAttachmentLinkUnknown,
    ]
})
export class PostAttachment
{
    @Input('attachment') link: PostAttachmentEntity<LinkAttachment<any>>;
    
    is(resource: string) {
        return this.link.attachment.resource === resource;
    }
}