import {Component, Input, ViewChild, ElementRef} from "angular2/core";

import {FeedbackService}               from "../../../../../../../../module/feedback/service/FeedbackService";
import {FeedbackEntity}                from "../../../../../../../../module/feedback/definitions/entity/Feedback";
import {FeedbackCreateResponseRequest} from "../../../../../../../../module/feedback/definitions/paths/create-response";

@Component({
    selector: 'cass-feedback-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class FeedbackModalComponent {
    @Input('feedback') feedback:FeedbackEntity;
    @ViewChild('feedbackModal') feedbackModal:ElementRef;
    private description:string;
        
    constructor(private service:FeedbackService){}
    reply() {
        this.service.response(<FeedbackCreateResponseRequest>{
            feedback_id: this.feedback.id,
            description: this.description
        }).subscribe(data => {
            alert("OK");
        })
    }

}