import {Component} from "@angular/core";

import {FeedbackCreateModal} from "./component/Modal/FeedbackCreateModal/index";
import {FeedbackCreateButton} from "./component/Elements/FeedbackCreateButton/index";
import {FeedbackTypeEntity} from "./definitions/entity/FeedbackType";
import {FeedbackTypesService} from "./service/FeedbackTypesService";
import {FeedbackCreateModalModel} from "./component/Modal/FeedbackCreateModal/model";
import {FeedbackService} from "./service/FeedbackService";
import {FeedbackRESTService} from "./service/FeedbackRESTService";

@Component({
    selector: 'cass-feedback',
    template: require('./template.jade'),
    providers:[
        FeedbackCreateModalModel,
        FeedbackService,
        FeedbackRESTService,
        FeedbackTypesService
    ]
})

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