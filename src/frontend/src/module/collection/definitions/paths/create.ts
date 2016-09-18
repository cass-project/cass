import {CollectionEntity} from "../entity/collection";
import {Success200} from "../../../common/definitions/common";

export interface CreateCollectionRequest
{
    owner_sid: string;
    theme_ids: number[];
    title: string;
    description: string;
}

export interface CreateCollectionResponse200 extends Success200
{
    entity: CollectionEntity;
}