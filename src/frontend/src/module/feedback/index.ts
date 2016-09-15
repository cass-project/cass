import {Component, Directive} from "@angular/core";
import {FeedbackTypeEntity} from "./definitions/entity/FeedbackType";
import {FeedbackTypesService} from "./service/FeedbackTypesService";
import {FeedbackCreateModalModel} from "./component/Modal/FeedbackCreateModal/model";
import {FeedbackService} from "./service/FeedbackService";
import {FeedbackRESTService} from "./service/FeedbackRESTService";

@Component({
    template: require('./template.jade'),
    providers:[
        FeedbackCreateModalModel,
        FeedbackService,
        FeedbackRESTService,
        FeedbackTypesService
    ]
})
@Directive({selector: 'cass-feedback'})

export class FeedbackComponent
{
    private feedbackType: FeedbackTypeEntity;
    public isModalOpen = false;

    close() {
        this.isModalOpen=false;
    }

    open(feedbackType:FeedbackTypeEntity) {
        this.feedbackType = feedbackType;
        this.isModalOpen=true;
    }

}