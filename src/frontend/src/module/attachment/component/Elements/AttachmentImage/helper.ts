import {AttachmentEntity} from "../../../definitions/entity/AttachmentEntity";
import {ImageAttachmentMetadata} from "../../../definitions/entity/metadata/ImageAttachmentMetadata";

export class AttachmentImageHelper
{
    constructor(
        public attachment: AttachmentEntity<ImageAttachmentMetadata>
    ) {}

    getImageURL(): string {
        return this.attachment.link.url;
    }
}