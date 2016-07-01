import {Component, Input, Output, EventEmitter} from "angular2/core";
import {Router} from 'angular2/router';

import {CurrentAccountService} from "../../../../auth/service/CurrentAccountService";
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
        private router: Router,
        private service: FeedbackService,
        private messages: MessageBusService,
        private feedbackTypesService: FeedbackTypesService,
        private currentAccountService: CurrentAccountService
    ) {}
    
    ngOnInit() {
        if(this.feedbackType) {
            this.model.type_feedback = this.feedbackType.code.int;
        } else {
            this.model.type_feedback = 1;
        }
        
        try {
            this.model.profile_id = this.currentAccountService.getCurrentProfile().getId();
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
                this.router.navigateByUrl("/");
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


    onFeedbackTypeChange($event) {
        this.router.navigate([
            'FeedbackCreateType', {
                type: this.feedbackTypesService.getFeedbackType($event).code.string
            }
        ]);
    }
}
