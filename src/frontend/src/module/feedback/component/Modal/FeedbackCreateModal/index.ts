import {Component, Input} from "angular2/core";
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
import {FeedbackTypeEntity} from "../../../definitions/entity/FeedbackType";

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
    @Input('feedbackType') feedbackType: FeedbackTypeEntity;
    
    constructor(
        public model: FeedbackCreateModalModel,
        private router: Router,
        private service: FeedbackService,
        private messages: MessageBusService,
        private feedbackTypesService: FeedbackTypesService,
        private currentAccountService: CurrentAccountService
    ) {}
    
    ngOnInit() {
        if(this.feedbackType){
            this.model.type_feedback = this.feedbackType.code.int;
        } else {
            this.model.type_feedback = 1;
        }
        
        try {
            this.model.profile_id = this.currentAccountService.getCurrentProfile().getId();
        } catch (Error) {}
    }
    
    abort() {
        this.router.navigateByUrl("/");
    }

    
    submit() {
        this.isLoading = true;
        this.service.create(<CreateFeedbackRequest>{
            profile_id: this.model.profile_id,
            type_feedback: this.model.type_feedback,
            description: this.model.description
        }).subscribe(
            data => {
                this.messages.push(MessageBusNotificationsLevel.Success, "Отзыв успешно отправлен!");
                this.router.navigateByUrl("/");
                this.isLoading = false;
            },
            error => {
                this.messages.push(MessageBusNotificationsLevel.Critical, JSON.parse(error._body))
                this.isLoading = false;
            }
        );
    }
    
    isModelValid(): boolean {
        return !!(this.model.type_feedback && this.model.description && (this.model.profile_id || this.model.email));
    }


    onFeedbackTypeChange($event) {
        this.router.navigate(['FeedbackCreateType', { type: this.feedbackTypesService.getFeedbackType($event).code.string}]);
    }
}
