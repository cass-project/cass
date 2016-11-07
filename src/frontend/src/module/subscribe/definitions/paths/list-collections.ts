import {Success200} from "../../../common/definitions/common";
import {SubscriptionEntity} from "../entity/Subscription";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";

export interface ListSubscribeCollections extends Success200
{
    subscribes: SubscriptionEntity<CollectionEntity>;
    total: number;
}

export interface ListSubscribeCollectionsRequest
{
    limit: number,
    offset: number
}