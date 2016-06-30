import {Component} from "angular2/core";
import {Location, Router} from 'angular2/router';

import {ModalComponent} from "../../../../modal/component/index";
import {ModalBoxComponent} from "../../../../modal/component/box/index";
import {FrontlineService} from "../../../../frontline/service";
import {FeedbackCreateModalModel} from "./model";
import {FeedbackService} from "../../../service/FeedbackService";
import {CreateFeedbackRequest} from "../../../definitions/paths/create";
import {CurrentAccountService} from "../../../../auth/service/CurrentAccountService";
import {MessageBusService} from "../../../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../../message/component/MessageBusNotifications/model";
import {ProgressLock} from "../../../../form/component/ProgressLock/index";

@Component({
    selector: 'cass-feedback-create-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
        ProgressLock
    ]
})

export class FeedbackCreateModal
{
    private feedbackTypes:any[] = [];
    private isLoading:boolean = false;
    constructor(
        public model: FeedbackCreateModalModel,
        private router: Router,
        private frontline: FrontlineService,
        private service: FeedbackService,
        private messages: MessageBusService,
        private accountService: CurrentAccountService
)
    {
        this.feedbackTypes = frontline.session.config.feedback.types;
    }
    
    abort() {
    }
    
    submit() {
        this.isLoading = true;
        this.service.create(<CreateFeedbackRequest>{
            profile_id: this.accountService.getCurrentProfile().getId(),
            type_feedback: this.model.type_feedback,
            description: this.model.description
        }).subscribe(
            data => {
                this.messages.push(MessageBusNotificationsLevel.Info, "Отзыв успешно отправлен!");
                this.router.navigateByUrl("/");
                this.isLoading = false;
            },
            error => {
                error._body = JSON.parse(error._body);
                if(error.status === 404) {
                    this.messages.push(MessageBusNotificationsLevel.Critical, error._body.error)
                } else {
                    console.log(error);
                }
                this.isLoading = false;
            }
        );
    }
}
