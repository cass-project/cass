import {Component} from "angular2/core";

import {FeedbackService} from "../../../../../module/feedback/service/FeedbackService";
import {FeedbackEntity} from "../../../../../module/feedback/definitions/entity/Feedback";
import {FeedbackRESTService} from "../../../../../module/feedback/service/FeedbackRESTService";
import {FeedbackCardComponent} from "./component/Elements/FeedbackCardComponent/index";
import {LandingSidebarComponent} from "../sidebar/component/LandingSidebarComponent/index";
import {LandingSidebarTogglerComponent} from "../sidebar/component/LandingSidebrTogglerComponent/index";


@Component({
    selector: 'cass-feedback-landing',
    template: require('./template.jade'),
    directives:[
        LandingSidebarComponent,
        FeedbackCardComponent,
        LandingSidebarTogglerComponent
    ],
    providers:[
        FeedbackService,
        FeedbackRESTService
    ]
})
export class FeedbackComponent {
    private feedbacks:FeedbackEntity[] = [];
    
    constructor(public service: FeedbackService) {
       service.list(0,10).subscribe(data => {
            this.feedbacks = data.entities;
        });
    }
}