import {Success200} from "../../../common/definitions/common";
import {PostEntity} from "../../../post/definitions/entity/Post";

export interface GetProfileFeedSuccess200 extends Success200
{
    entities: PostEntity[];
}