import {ProfileEntity} from "../../../profile/definitions/entity/Profile";
import {CommunityEntity} from "../../../community/definitions/entity/Community";

export interface IMMessageSourceEntity<T extends IMMessageSourceEntityType>
{
    code: IMMessageSourceEntityTypeCode,
    entity: T
}

export type IMMessageSourceEntityType = ProfileEntity & CommunityEntity;
export type IMMessageSourceEntityTypeCode = "profile" | "community";
