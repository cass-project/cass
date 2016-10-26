import {Success200} from "../../../common/definitions/common";
import {SubscriptionEntity} from "../entity/Subscription";

export interface UnsubscribeCommunity extends Success200
{
    entity: SubscriptionEntity;
}