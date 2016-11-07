import {Success200} from "../../../common/definitions/common";
import {SubscriptionEntity} from "../entity/Subscription";
import {Theme} from "../../../theme/definitions/entity/Theme";

export interface SubscribeTheme extends Success200
{
    subscribe: SubscriptionEntity<Theme>;
}