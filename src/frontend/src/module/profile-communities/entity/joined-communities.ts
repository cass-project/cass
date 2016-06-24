import {Success200} from "../../common/definitions/common";
import {ProfileCommunityBookmarkEntity} from "../definitions/ProfileCommunityBookmark";

export interface JoinedCommunitiesResponse200 extends Success200
{
    bookmarks: ProfileCommunityBookmarkEntity[];
}