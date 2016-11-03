import {Success200} from "../../../common/definitions/common";
import {SubscriptionEntity} from "../entity/Subscription";

export interface ListThemes extends Success200
{
    entities: SubscriptionEntity[];
}

export interface ListThemesRequest
{
    limit: number,
    offset: number
}