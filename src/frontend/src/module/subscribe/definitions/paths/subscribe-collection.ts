import {Success200} from "../../../common/definitions/common";
import {SubscriptionEntity} from "../entity/Subscription";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";

export interface SubscribeCollection extends Success200
{
    subscribe: SubscriptionEntity<CollectionEntity>;
}