export const SUBSCRIBE_TYPE_THEME = 1;
export const SUBSCRIBE_TYPE_PROFILE = 2;
export const SUBSCRIBE_TYPE_COLLECTION = 3;
export const SUBSCRIBE_TYPE_COMMUNITY = 4;

export interface SubscriptionEntity<T>
{
    id: number;
    profile_id: number;
    subscribe_id: number;
    subscribe_type: number;
    entity: T;
}
