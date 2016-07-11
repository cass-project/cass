import {Success200} from "../../../common/definitions/common";
import {PostEntity} from "../../../post/definitions/entity/Post";

export interface GetCollectionSuccess200 extends Success200
{
    entities: PostEntity[];
}