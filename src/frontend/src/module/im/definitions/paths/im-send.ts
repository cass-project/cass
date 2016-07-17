import {Success200} from "../../../common/definitions/common";
import {IMMessageEntity} from "../entity/IMMessage";

export interface IMSendRequest
{
    message: string;
    attachment_ids: number[];
}

export interface IMSendResponse200 extends Success200
{
    message: IMMessageEntity;
}