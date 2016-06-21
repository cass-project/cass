import {Success200} from "../../../common/definitions/common";
import {CommunityEntity} from "../entity/Community";

export interface CreateCommunityRequest
{
    title: string;
    description: string;
    theme_id: number;
}

export interface CreateCommunityResponse200 extends Success200
{
    entity: CommunityEntity;
}