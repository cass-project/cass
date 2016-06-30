import {Component} from "angular2/core";
import {RouteParams} from "angular2/router";
import {FeedbackCreateModal} from "../../component/Modal/FeedbackCreateModal/index";
import {FeedbackCreateModalModel} from "../../component/Modal/FeedbackCreateModal/model";
import {FeedbackTypesService} from "../../service/FeedbackTypesService";

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
    constructor (
        private routeParams: RouteParams,
        private feedbackTypesService: FeedbackTypesService,
        private model: FeedbackCreateModalModel
    ){
        let feedbackType = feedbackTypesService.getFeedbackType(this.routeParams.get("type"));

        model.type_feedback = feedbackType? 
            feedbackType.code.int : feedbackTypesService.getFeedbackTypes()[0].code.int; 
    }
    

}