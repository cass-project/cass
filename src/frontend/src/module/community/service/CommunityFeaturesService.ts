import {Injectable} from "@angular/core";

import {FrontlineService} from "../../frontline/service";
import {CommunityFeatureEntity} from "../definitions/entity/CommunityFeature";

@Injectable()
export class CommunityFeaturesService
{
    private features: CommunityFeatureEntity[] = [];

    constructor(
        private frontline: FrontlineService
    ) {
        this.features = frontline.session.config.community.features;
    }

    findFeature(code: string): CommunityFeatureEntity {
        return this.features.filter(feature => {
            return feature.code === code;
        })[0];
    }

    getFeatures() {
        return this.features;
    }

    getName(code) : string {
        return this.findFeature(code).code;
    }

    getIcon(code) : string {
        return this.findFeature(code).fa_icon;
    }

    getDescription(code) : string {
        return this.findFeature(code).code;
    }

    isDisabled(code) : boolean {
        return this.findFeature(code).is_production_ready;
    }
}