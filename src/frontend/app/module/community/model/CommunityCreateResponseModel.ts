import {CommunityEntity} from "../definitions/entity/Community";

export class CommunityCreateResponseModel {
    access: {
        admin: boolean
    };
    entity: CommunityEntity;
    success: boolean;
}

