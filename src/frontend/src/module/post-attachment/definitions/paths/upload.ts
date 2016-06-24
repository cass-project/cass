import {Success200} from "../../../common/definitions/common";
import {PostAttachmentEntity} from "../entity/PostAttachment";

export interface UploadPostAttachmentResponse200 extends Success200
{
    entity: PostAttachmentEntity;
}