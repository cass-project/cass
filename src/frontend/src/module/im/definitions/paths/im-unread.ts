import {Success200} from "../../../common/definitions/common";
import {IMMessageSourceEntity, IMMessageSourceEntityType} from "../entity/IMMessageSource";

export interface IMUnread extends Success200
{
    unread: {
        source: IMMessageSourceEntity<IMMessageSourceEntityType>;
        count: number;
    }[];
}