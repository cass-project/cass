import {CommunityEntity} from "../definitions/entity/Community";
import {CollectionEntity} from "../../collection/definitions/entity/collection";

export class CommunityCreateResponseModel {
    entity: {
        community: CommunityEntity,
        collections: CollectionEntity,
        is_own: boolean
    };
    success: boolean;
}

