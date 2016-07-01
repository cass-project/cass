import {Injectable} from "angular2/core";

import {FrontlineService} from "../../frontline/service";
import {FrontlineEntity} from "../../frontline/definitions/entity/Frontline";
import {FeedbackTypeEntity} from "../definitions/entity/FeedbackType";

@Injectable()
export class FeedbackTypesService
{
    private frontline: FrontlineEntity;
    
    constructor(private frontlineService: FrontlineService)
    {
        this.frontline = frontlineService.session;
    }
    
    getFeedbackTypes() : FeedbackTypeEntity[]
    {
        return this.frontline.config.feedback.types;
    }
    
    getFeedbackType(code:string|number): FeedbackTypeEntity {
        let feedbackType:FeedbackTypeEntity[] = this.getFeedbackTypes().filter((input) => {
            return input.code.string === code || input.code.int == code;
        });
        
        if(feedbackType.length>0) {
            return feedbackType[0];
        } else {
            throw new Error(`Unknown feedbackType "${code}"`);
        }
    }
}