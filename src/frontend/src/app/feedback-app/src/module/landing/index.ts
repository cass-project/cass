import {Component} from "angular2/core";

import {LandingSidebarComponent} from "./component/Elements/LandingSidebarComponent/index";
import {LandingSidebarTogglerComponent} from "./component/Elements/LandingSidebrTogglerComponent/index";
import {CardComponent} from "../feedback-card/component/Card/FeedbackCard/index";
import {FeedbackService} from "../../../../../module/feedback/service/FeedbackService";
import {FeedbackEntity} from "../../../../../module/feedback/definitions/entity/Feedback";
import {FeedbackRESTService} from "../../../../../module/feedback/service/FeedbackRESTService";


@Component({
    selector: 'cass-feedback-landing',
    template: require('./template.jade'),
    directives:[
        LandingSidebarComponent,
        CardComponent,
        LandingSidebarTogglerComponent
    ],
    providers:[
        FeedbackService,
        FeedbackRESTService
    ]
})
export class LandingComponent {
    private feedbacks:FeedbackEntity[];

    constructor(public service: FeedbackService) {
        service.list(0,10).subscribe(data=>{
            this.feedbacks = data.entities;
        });
    }
}