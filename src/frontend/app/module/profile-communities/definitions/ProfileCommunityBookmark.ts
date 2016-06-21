import {CommunityEntity} from "../../community/definitions/entity/Community";

export interface ProfileCommunityBookmarkEntity
{
    id: number;
    community_id: number;
    community_sid: string;
    profile_id: number;
    community: CommunityEntity;
}