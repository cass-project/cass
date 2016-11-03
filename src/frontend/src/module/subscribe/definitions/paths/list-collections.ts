import {Success200} from "../../../common/definitions/common";
import {SubscriptionEntity} from "../entity/Subscription";

export interface ListCollections extends Success200
{
    entity: SubscriptionEntity;
}

export interface ListCollectionsRequest
{
    limit: number,
    offset: number
}