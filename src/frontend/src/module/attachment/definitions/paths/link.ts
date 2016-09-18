import {Success200} from "../../../common/definitions/common";
import {AttachmentEntity, AttachmentMetadata} from "../entity/AttachmentEntity";

export interface LinkAttachmentResponse200 extends Success200
{
    entity: AttachmentEntity<AttachmentMetadata>;
}