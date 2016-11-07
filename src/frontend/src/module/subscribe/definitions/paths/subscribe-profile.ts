import {Success200} from "../../../common/definitions/common";
import {SubscriptionEntity} from "../entity/Subscription";
import {ProfileEntity} from "../../../profile/definitions/entity/Profile";

export interface SubscribeProfile extends Success200
{
    subscribe: SubscriptionEntity<ProfileEntity>;
}