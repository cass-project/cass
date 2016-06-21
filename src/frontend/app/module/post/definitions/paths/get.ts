import {Success200} from "../../../common/definitions/common";
import {PostEntity} from "../entity/Post";

export interface GetPostResponse200 extends Success200
{
    entity: PostEntity;
}