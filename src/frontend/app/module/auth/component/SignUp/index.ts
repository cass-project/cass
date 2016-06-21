import {Component, Output, EventEmitter} from "angular2/core";

import {OAuth2Component} from "../OAuth2/index";
import {AuthService, SignUpModel, SignInResponse} from "../../service/AuthService";
import {MessageBusService} from "../../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../message/component/MessageBusNotifications/model";
import {LoadingIndicator} from "../../../form/component/LoadingIndicator/index";

@Component({
    selector: 'cass-auth-sign-up',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        LoadingIndicator,
        OAuth2Component
    ]
})
export class SignUpComponent
{
    @Output('back') backEvent = new EventEmitter<SignUpModel>();
    @Output('close') closeEvent = new EventEmitter<SignUpModel>();
    @Output('success') successEvent = new EventEmitter<SignInResponse>();
    
    private status: SignUpStatus = {
        loading: false
    };

    private model: SignUpModel = {
        email: '',
        password: '',
        repeat: '',
    };

    constructor(
        private authService: AuthService,
        private messages: MessageBusService
    ) {}

    submit() {
        this.status.loading = true;

        this.authService.attemptSignUp(this.model)
            .then(response => {
                this.successEvent.emit(response);
            })
            .catch(error => {
                this.messages.push(MessageBusNotificationsLevel.Warning, error);
            })
            .then(() => {
                this.status.loading = false;
            })
        ;
    }

    close() {
        this.closeEvent.emit(this.model);
    }

    back() {
        this.backEvent.emit(this.model);
    }
}

interface SignUpStatus
{
    loading: boolean;
}