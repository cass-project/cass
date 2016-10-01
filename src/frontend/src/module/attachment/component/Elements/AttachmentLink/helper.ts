import {UnknownAttachmentMetadata} from "../../../definitions/entity/metadata/UnknownAttachmentMetadata";
import {AttachmentEntity} from "../../../definitions/entity/AttachmentEntity";

export class AttachmentLinkHelper
{
    constructor(public attachment: AttachmentEntity<UnknownAttachmentMetadata>
    ) {}

    getURL(): string {
        return this.attachment.link.url
    }
}