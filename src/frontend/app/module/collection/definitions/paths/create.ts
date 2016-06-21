import {CollectionEntity} from "../entity/collection";
import {Success200} from "../../../common/definitions/common";

export interface CreateCollectionResponse200 extends Success200
{
    entity: CollectionEntity;
}