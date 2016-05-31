import {Injectable} from "angular2/core";
import {FrontlineService} from "../../frontline/service";

@Injectable()
export class CommunityFeaturesService
{
    private featuresInfo:FeaturesInfo[] = [
        {code:"collections", "name": "Коллекции", "description":"Создание коллекций постов."},
        {code:"board", "name": "Форум", "description":"Находится в стадии разработки"},
        {code:"chat", "name": "Чат", "description":"Находится в стадии разработки"}
    ];
    private features;

    constructor(private frontline: FrontlineService) {
        this.features = frontline.session.config.community.features;
    }

    getName(code) : string {
        return this.getFeatureInfo(code).name;
    }

    getDescription(code) : string {
        return this.getFeatureInfo(code).description;
    }

    getFeatureInfo(code) : FeaturesInfo {
        for(let feature of this.featuresInfo) {
            if(feature.code === code) {
                return feature;
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