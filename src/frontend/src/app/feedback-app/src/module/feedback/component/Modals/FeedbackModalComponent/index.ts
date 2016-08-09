import {Component, Input, ViewChild, ElementRef} from "@angular/core";

import {FeedbackService} from "../../../../../../../../module/feedback/service/FeedbackService";
import {MessageBusService} from "../../../../../../../../module/message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../../../../../../module/message/component/MessageBusNotifications/model";
import {FeedbackEntity} from "../../../../../../../../module/feedback/definitions/entity/Feedback";
import {FeedbackCreateResponseRequest} from "../../../../../../../../module/feedback/definitions/paths/create-response";

declare var jQuery;

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
        
    constructor(private service:FeedbackService, private message:MessageBusService){}
    
    reply() {
        jQuery(this.feedbackModal.nativeElement).modal('hide');
        this.message.push(MessageBusNotificationsLevel.Info, "Sending...");
        this.service.response(<FeedbackCreateResponseRequest>{
            feedback_id: this.feedback.id,
            description: this.description
        }).subscribe(
            () => {
                this.message.replaceLast(MessageBusNotificationsLevel.Success, "Success!");
            },
            error => {
                this.message.replaceLast(MessageBusNotificationsLevel.Critical, JSON.parse(error._body).error);
            }
        )
    }
    
    isValid() {
        return this.feedback.id && this.description;
    }
}