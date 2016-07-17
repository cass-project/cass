import {Success200} from "../../../common/definitions/common";
import {CommunityExtendedEntity} from "../entity/CommunityExtended";

export interface CreateCommunityRequest
{
    title: string;
    description: string;
    theme_id: number;
}

export interface CreateCommunityResponse200 extends Success200
{
    entity: CommunityExtendedEntity;
}