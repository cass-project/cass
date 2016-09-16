import {Component, Input} from "@angular/core";
import {AttachmentEntity} from "../../../definitions/entity/AttachmentEntity";
import {UnknownAttachmentMetadata} from "../../../definitions/entity/metadata/UnknownAttachmentMetadata";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector:  'cass-post-attachment-link-unknown'})

export class AttachmentLinkUnknown
{
    @Input('attachment') attachment: AttachmentEntity<UnknownAttachmentMetadata>;
    
    getURL(): string {
        return this.attachment.link.url
    }
}