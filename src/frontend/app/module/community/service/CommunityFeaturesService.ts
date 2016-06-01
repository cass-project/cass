import {Injectable} from "angular2/core";
import {FrontlineService} from "../../frontline/service";

@Injectable()
export class CommunityFeaturesService
{
    private featuresInfo:FeaturesInfo[] = [
        {
            "code":"collections",
            "name": "Коллекции",
            "description":"Подключив фичу Коллекции, Вы сможете создавать посты товаров и объединять их в подборки. На главной странице комммунити будет отображаться блок с коллекциями."
        },
        {
            "code":"boards",
            "name": "Форум",
            "description":"Находится в стадии разработки"
        },
        {
            "code":"chat",
            "name": "Чат",
            "description":"Находится в стадии разработки"}
    ];
    private features;

    constructor(private frontline: FrontlineService) {
        this.features = frontline.session.config.community.features;
    }

    getFeatures() {
        return this.features;
    }

    getName(code) : string {
        return this.getFeatureInfo(code).name;
    }

    getDescription(code) : string {
        return this.getFeatureInfo(code).description;
    }

    getFeatureInfo(code) : FeaturesInfo {
        for(let featureInfo of this.featuresInfo) {
            if(featureInfo.code === code) {
                return featureInfo;
            }
        }
    }

    isDisabled(code) : boolean {
        for(let feature of this.features) {
            if(feature.code===code) {
                return !feature.is_production_ready;
            }
        }
    }
}

class FeaturesInfo
{
    code:string = "";
    name:string = "";
    description:string = "";
}