import {Success200} from "../../../common/definitions/common";
import {SubscriptionEntity} from "../entity/Subscription";
import {Theme} from "../../../theme/definitions/entity/Theme";

export interface ListSubscribeThemes extends Success200
{
    subscribes: SubscriptionEntity<Theme>[];
}

export interface ListSubscribeThemesRequest
{
    limit: number,
    offset: number
}
