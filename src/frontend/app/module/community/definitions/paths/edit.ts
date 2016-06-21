import {Success200} from "../../../common/definitions/common";
import {CommunityEntity} from "../entity/Community";

export interface EditCommunityRequest
{
    title: string;
    description: string;
    theme_id: number;
}

export interface EditCommunityResponse200 extends Success200
{
    entity: CommunityEntity;
}