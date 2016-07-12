import {Success200} from "../../../common/definitions/common";
import {PostAttachmentEntity} from "../entity/PostAttachment";
import {FileAttachment} from "../entity/attachment/FileAttachment";
import {LinkAttachment} from "../entity/attachment/LinkAttachment";

export interface LinkPostAttachmentResponse200 extends Success200
{
    entity: PostAttachmentEntity<LinkAttachment<any>>;
}