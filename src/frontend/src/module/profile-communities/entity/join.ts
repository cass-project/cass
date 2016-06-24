import {Success200} from "../../common/definitions/common";
import {ProfileCommunityBookmarkEntity} from "../definitions/ProfileCommunityBookmark";

export interface JoinCommunityResponse200 extends Success200
{
    entity: ProfileCommunityBookmarkEntity;
}