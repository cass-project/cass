import {Injectable} from "angular2/core";

import {FrontlineService} from "../../frontline/service";

@Injectable()
export class CommunityFeaturesService
{
    private featuresInfo:FeaturesInfo[] = [
        {
            "code":"collections",
            "name": "Коллекции",
            "icon": "fa-bookmark",
            "description":"Активировав этот модуль, участники и/или модераторы этого коммунити могут создавать подборки контента, постить видео, ссылки, изображения и любые другие материалы."
        },
        {
            "code":"boards",
            "name": "Форум",
            "icon": "fa-list-ul",
            "description":"Доска объявлений, система форумов для вашего коммунити."
        },
        {
            "code":"chat",
            "name": "Чат",
            "icon": "fa-comments",
            "description":"Добавить коллективные чаты в ваше коммунити."}
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

export class FeaturesInfo
{
    code:string;
    name:string;
    icon:string;
    description:string;
}