import {Injectable} from "angular2/core";

import {FrontlineService} from "../../frontline/service";
import {FeaturesInfo} from "../enity/FeaturesInfo";

@Injectable()
export class CommunityFeaturesService
{
    private featuresInfo:FeaturesInfo[] = [
        {
            "code":"collections",
            "name": "Коллекции",
            "icon": "fa-folder-open",
            "description":"Подключив фичу Коллекции, Вы сможете создавать посты товаров и объединять их в подборки. На главной странице комммунити будет отображаться блок с коллекциями."
        },
        {
            "code":"boards",
            "name": "Форум",
            "icon": "fa-users",
            "description":"Находится в стадии разработки"
        },
        {
            "code":"chat",
            "name": "Чат",
            "icon": "fa-comments-o",
            "description":"Находится в стадии разработки"}
    ];
    private features;

    constructor(private frontline: FrontlineService)
    {
        this.features = frontline.session.config.community.features;
    }

    getFeatures()
    {
        return this.features;
    }

    getName(code) : string
    {
        return this.getFeatureInfo(code).name;
    }

    getIcon(code) : string
    {
        return this.getFeatureInfo(code).icon;
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