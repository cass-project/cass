import {WebmAttachmentMetadata} from "../../../definitions/entity/metadata/WebmAttachmentMetadata";
import {AttachmentEntity} from "../../../definitions/entity/AttachmentEntity";

export class AttachmentWebmHelper
{
    constructor(
        public attachment: AttachmentEntity<WebmAttachmentMetadata>
    ) {}

    getType(): string {
        return this.attachment.link.metadata.type;
    }

    getURL(): string {
        return this.attachment.link.url;
    }

    getCover(): string {
        return this.attachment.link.metadata.preview.public;
    }
}