import {Success200} from "../../../common/definitions/common";
import {SubscriptionEntity} from "../entity/Subscription";

export interface ListCollections extends Success200
{
    entity: SubscriptionEntity;
}

export interface ListCollectionsRequest extends Success200
{
    limit: number,
    offset: number
}