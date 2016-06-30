import {Component} from "angular2/core";
import {Router} from 'angular2/router';

import {ModalComponent} from "../../../../modal/component/index";
import {ModalBoxComponent} from "../../../../modal/component/box/index";
import {FeedbackCreateModalModel} from "./model";
import {FeedbackService} from "../../../service/FeedbackService";
import {CreateFeedbackRequest} from "../../../definitions/paths/create";
import {CurrentAccountService} from "../../../../auth/service/CurrentAccountService";
import {MessageBusService} from "../../../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../../message/component/MessageBusNotifications/model";
import {ProgressLock} from "../../../../form/component/ProgressLock/index";
import {FeedbackTypesService} from "../../../service/FeedbackTypesService";

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
    private isLoading:boolean = false;
    constructor(
        public model: FeedbackCreateModalModel,
        private router: Router,
        private feedbackTypesService: FeedbackTypesService,
        private service: FeedbackService,
        private messages: MessageBusService,
        private accountService: CurrentAccountService
)
    {
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
                this.messages.push(MessageBusNotificationsLevel.Success, "Отзыв успешно отправлен!");
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
