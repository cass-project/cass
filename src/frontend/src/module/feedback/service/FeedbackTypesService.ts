import {Injectable} from "angular2/core";

import {FrontlineService} from "../../frontline/service";
import {FrontlineEntity} from "../../frontline/definitions/entity/Frontline";

@Injectable()
export class FeedbackTypesService
{
    private frontline: FrontlineEntity;
    
    constructor(private frontlineService: FrontlineService)
    {
        this.frontline = frontlineService.session;
    }
    
    getFeedbackTypes()
    {
        return this.frontline.config.feedback.types;
    }
    
    getFeedbackType(code:string|number) {
        return this.getFeedbackTypes().filter((input) => {
            return input.code.string === code || input.code.int == code;
        })[0];
    }

}