import {Injectable} from "@angular/core";

import {CreateCommunityRequest} from "../../../definitions/paths/create";
import {CommunityFeatureEntity} from "../../../../community-features/definitions/entity/CommunityFeature";

@Injectable()
export class CommunityCreateModalModel
{
    title: string = "";
    sid: string;
    description: string = "";
    theme_ids: Array<number> = [];
    features: CommunityFeatureEntity[] = [];
    
    createRequest(): CreateCommunityRequest{
        return {
            title: this.title,
            description: this.description,
            theme_id: this.theme_ids[0]
        };
    }
}