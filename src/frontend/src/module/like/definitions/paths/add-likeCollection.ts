import {Success200} from "../../../common/definitions/common";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";
import {LikeEntity} from "../entity/Like";

export interface LikeCollectionResponse extends Success200
{
    entity: LikeEntity<CollectionEntity>;

}
