import {CommunityEntity} from "./Community";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";

export interface CommunityExtendedEntity
{
    community: CommunityEntity;
    collections: CollectionEntity[];
    is_own: boolean;
    subscribed: boolean;
}