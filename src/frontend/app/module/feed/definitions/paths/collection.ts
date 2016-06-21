import {Success200} from "../../../common/definitions/common";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {ProfileEntity} from "../../../profile/definitions/entity/Profile";

export interface FeedCollectionResponse200 extends Success200
{
    cached_profiles: ProfileEntity[];
    posts: PostEntity[];
    total: number;
}