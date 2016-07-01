import {Component} from "angular2/core";
import {RouteParams} from "angular2/router";

import {FeedbackCreateModal} from "../../component/Modal/FeedbackCreateModal/index";
import {FeedbackTypesService} from "../../service/FeedbackTypesService";
import {FeedbackTypeEntity} from "../../definitions/entity/FeedbackType";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        FeedbackCreateModal
    ]
})

export class FeedbackCreateRoute
{
    private feedbackType: FeedbackTypeEntity;
    constructor (
        private routeParams: RouteParams,
        private feedbackTypesService: FeedbackTypesService
    ){
        try {
            this.feedbackType = feedbackTypesService.getFeedbackType(routeParams.get("type"));
        } catch (Error) {
            this.feedbackType = feedbackTypesService.getFeedbackType(1);
        }
    }
}