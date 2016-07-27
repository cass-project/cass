import {Success200} from "../../../common/definitions/common";
import {IMMessageSourceEntity, IMMessageSourceEntityType} from "../entity/IMMessageSource";

export interface IMUnreadResponse200 extends Success200
{
    unread: IMUnreadResponseEntity[];
}

export interface IMUnreadResponseEntity
{
    source: IMMessageSourceEntity<IMMessageSourceEntityType>;
    counter: number;
}