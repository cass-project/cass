import {Component, Input} from "@angular/core";
import {AttachmentEntity} from "../../../definitions/entity/AttachmentEntity";
import {WebmAttachmentMetadata} from "../../../definitions/entity/metadata/WebmAttachmentMetadata";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector:  'cass-post-attachment-link-webm'})

export class AttachmentLinkWebm
{
    @Input('attachment') attachment: AttachmentEntity<WebmAttachmentMetadata>;
    
    getType(): string {
        return this.attachment.link.metadata.type;
    }

    getURL(): string {
        return this.attachment.link.url;
    }

    getCover(): string {
        if(this.attachment.link.version >= 2) {
            return this.attachment.link.metadata.preview.public;
        }else{
            return '';
        }
    }
}