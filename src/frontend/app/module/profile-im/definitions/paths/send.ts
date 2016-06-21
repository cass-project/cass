import {Success200} from "../../../common/definitions/common";
import {ProfileMessageEntity} from "../entity/ProfileMessage";

export interface SendProfileMessageRequest
{
    content: string;
}

export interface SendProfileMessageResponse200 extends Success200
{
    message: ProfileMessageEntity;
}