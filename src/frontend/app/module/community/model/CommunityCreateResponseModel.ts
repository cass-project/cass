import {CommunityEnity} from "../enity/Community";

export class CommunityCreateResponseModel {
    access: {
        admin: boolean
    };
    entity: CommunityEnity;
    success: boolean;
}

