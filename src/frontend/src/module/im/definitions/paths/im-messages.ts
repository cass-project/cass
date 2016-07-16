import {Success200} from "../../../common/definitions/common";
import {IMMessageSource} from "../entity/IMMessageSource";
import {IMMessageEntity} from "../entity/IMMessage";

export interface IMMessagesRequest
{
    criteria: {
        seek: {
            offset: number;
            limit: number;
        },
        cursor?: {
            id: string;
        }
    };
    options: {
        includeTargetMessages?: {
            enabled: boolean;
        },
        explicitDirection?: {
            enabled: boolean;
        },
        markAsRead?: number[];
    };
}

export interface IMMessagesResponse200<T> extends Success200
{
    source: IMMessageSource<T>;
    messages: IMMessageEntity[];
}