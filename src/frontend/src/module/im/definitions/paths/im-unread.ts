import {Success200} from "../../../common/definitions/common";
import {IMMessageSource} from "../entity/IMMessageSource";

export interface IMUnread extends Success200
{
    unread: {
        source: IMMessageSource<any>;
        count: number;
    }[];
}