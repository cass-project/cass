import {Success200} from "../../../common/definitions/common";
import {CommunityExtendedEntity} from "../entity/CommunityExtended";

export interface EditCommunityRequest
{
    title: string;
    description: string;
    theme_id: number;
}

export interface EditCommunityResponse200 extends Success200
{
    entity: CommunityExtendedEntity;
}