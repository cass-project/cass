import {Component, Input, ViewChild} from "angular2/core";
import {FeedbackEntity} from "../../../../../../../../module/feedback/definitions/entity/Feedback";
import {ElementRef_} from "angular2/src/core/linker/element_ref";
import {FeedbackService} from "../../../../../../../../module/feedback/service/FeedbackService";
import {FeedbackRESTService} from "../../../../../../../../module/feedback/service/FeedbackRESTService";
import {FeedbackCreateResponseRequest} from "../../../../../../../../module/feedback/definitions/paths/create-response";

@Component({
    selector: 'cass-feedback-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers:[
        FeedbackService,
        FeedbackRESTService
    ]
})
export class FeedbackModalComponent {
    @Input('feedback') feedback:FeedbackEntity;
    @ViewChild('feedbackModal') feedbackModal:ElementRef_;
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