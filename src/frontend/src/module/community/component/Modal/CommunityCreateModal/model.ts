import {Injectable} from "@angular/core";

import {CreateCommunityRequest} from "../../../definitions/paths/create";

@Injectable()
export class CommunityCreateModalModel
{
    title: string = "";
    sid: string;
    description: string = "";
    theme_ids: Array<number> = [];
    features: CommunityFeaturesModel[] = [];
    
    createRequest(): CreateCommunityRequest {
        return {
            title: this.title,
            description: this.description,
            theme_id: this.theme_ids[0]
        };
    }
}

export interface CommunityFeaturesModel
{
    code: string;
    is_activated: boolean;
    disabled: boolean;
}