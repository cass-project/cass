import {Component, Input, Output, EventEmitter} from "@angular/core";

import {FeedbackCreateModalModel} from "./model";
import {FeedbackService} from "../../../service/FeedbackService";
import {FeedbackTypesService} from "../../../service/FeedbackTypesService";
import {FeedbackCreateRequest} from "../../../definitions/paths/create";
import {FeedbackTypeEntity} from "../../../definitions/entity/FeedbackType";
import {MessageBusService} from "../../../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../../message/component/MessageBusNotifications/model";
import {ModalComponent} from "../../../../modal/component/index";
import {ModalBoxComponent} from "../../../../modal/component/box/index";
import {ProgressLock} from "../../../../form/component/ProgressLock/index";
import {AuthService} from "../../../../auth/service/AuthService";

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
    @Input('feedback-type') feedbackType: FeedbackTypeEntity;
    @Output('close') closeEvent = new EventEmitter<FeedbackCreateModal>();

    constructor(
        public model: FeedbackCreateModalModel,
        private service: FeedbackService,
        private messages: MessageBusService,
        private feedbackTypesService: FeedbackTypesService,
        private authService: AuthService
    ) {}

    ngOnInit() {
        this.model.description="";
        this.model.type_feedback = 1;
        
        if(this.feedbackType) {
            this.model.type_feedback = this.feedbackType.code.int;
        }

        try {
            this.model.profile_id = this.authService.getCurrentAccount().getCurrentProfile().getId();
        } catch (Error) {}
    }

    abort() {
        this.closeEvent.emit(this);
    }


    submit() {
        this.isLoading = true;
        this.service.create(<FeedbackCreateRequest>this.model).subscribe(
            data => {
                this.messages.push(MessageBusNotificationsLevel.Success, "Отзыв успешно отправлен!");
                this.closeEvent.emit(this);
                this.isLoading = false;
            },
            error => {
                this.messages.push(MessageBusNotificationsLevel.Critical, JSON.parse(error._body).error);
                this.isLoading = false;
            }
        );
    }

    isModelValid(): boolean {
        return !!(this.model.type_feedback && this.model.description && (this.model.profile_id || this.model.email));
    }
}
