import {Success200} from "../../../common/definitions/common";
import {IMMessageSourceEntity, IMMessageSourceEntityType} from "../entity/IMMessageSource";
import {IMMessageEntity} from "../entity/IMMessage";

export interface IMMessagesBodyRequest
{
    criteria: {
        seek: {
            offset?: number,
            limit?: number
        },
        cursor?: {
            id: string
        },
        sort?: {
            field: string,
            order: string
        }
    },
    options?: {
        markAsRead?: number[]
    }
}

export interface IMMessagesResponse200<T extends IMMessageSourceEntityType> extends Success200
{
    source: IMMessageSourceEntity<T>,
    messages: IMMessageEntity[]
}