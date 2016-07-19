import {CommunityEntity} from "../../community/definitions/entity/Community";

export interface ProfileCommunityBookmarkEntity
{
    community_id: number;
    community_sid: string;
    profile_id: number;
    community: CommunityEntity;
}