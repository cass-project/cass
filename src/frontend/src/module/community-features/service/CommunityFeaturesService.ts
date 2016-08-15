import {Injectable} from "@angular/core";

import {FrontlineService} from "../../frontline/service";
import {FrontlineCommunityFeaturesEntity} from "../definitions/entity/CommunityFeature";

@Injectable()
export class CommunityFeaturesService
{
    private featuresInfo: FeaturesInfo[] = [
        {
            "code": "collections",
            "name": "Коллекции",
            "description": "Активировав этот модуль, участники и/или модераторы этого коммунити могут создавать подборки контента, постить видео, ссылки, изображения и любые другие материалы."
        },
        {
            "code": "boards",
            "name": "Форум",
            "description": "Доска объявлений, система форумов для вашего коммунити."
        },
        {
            "code": "chat",
            "name": "Чат",
            "description": "Добавить коллективные чаты в ваше коммунити."}
    ];
    private features: FrontlineCommunityFeaturesEntity[];

    constructor(private frontline: FrontlineService)
    {
        this.features = frontline.session.config.community.features;
    }

    getFeatures(): FrontlineCommunityFeaturesEntity[]
    {
        return this.features;
    }

    getName(code): string
    {
        return this.getFeatureInfo(code).name;
    }

    getIcon(code): string
    {
        for(let feature of this.features) {
            if(feature.code===code) {
                return feature.fa_icon;
            }
        }
    }

    getDescription(code) : string
    {
        return this.getFeatureInfo(code).description;
    }

    getFeatureInfo(code) : FeaturesInfo
    {
        for(let featureInfo of this.featuresInfo) {
            if(featureInfo.code === code) {
                return featureInfo;
            }
        }
    }

    isDisabled(code) : boolean
    {
        for(let feature of this.features) {
            if(feature.code===code) {
                return !feature.is_production_ready;
            }
        }
    }
}

export interface FeaturesInfo
{
    code: string;
    name: string;
    description?: string;
}