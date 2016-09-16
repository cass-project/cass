import {Component, Input} from "@angular/core";
import {AttachmentEntity, AttachmentMetadata} from "../../../definitions/entity/AttachmentEntity";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-post-attachment'})

export class Attachment
{
    @Input('attachment') attachment: AttachmentEntity<AttachmentMetadata>;
    
    is(resource: string) {
        return this.attachment.link.resource === resource;
    }
}