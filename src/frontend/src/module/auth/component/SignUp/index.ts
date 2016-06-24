import {Component, Output, EventEmitter} from "angular2/core";

import {OAuth2Component} from "../OAuth2/index";
import {AuthService, SignInResponse} from "../../service/AuthService";
import {MessageBusService} from "../../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../message/component/MessageBusNotifications/model";
import {LoadingIndicator} from "../../../form/component/LoadingIndicator/index";
import {SignInRequest} from "../../definitions/paths/sign-in";
import {SignUpRequest} from "../../definitions/paths/sign-up";
import {AuthRESTService} from "../../service/AuthRESTService";

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
    @Output('back') backEvent = new EventEmitter<SignInRequest>();
    @Output('close') closeEvent = new EventEmitter<SignUpRequest>();
    @Output('success') successEvent = new EventEmitter();
    
    private status: SignUpStatus = {
        loading: false
    };

    private model: SignUpRequest = {
        email: '',
        password: '',
        repeat: '',
    };

    constructor(
        private authRESTService: AuthRESTService,
        private messages: MessageBusService
    ) {}

    submit() {
        this.status.loading = true;

        this.authRESTService.signUp(this.model).subscribe(
            response =>{
                this.successEvent.emit(response);
                this.status.loading = false;
            },
            error => {this.messages.push(MessageBusNotificationsLevel.Warning, error);
                this.status.loading = false;
            });
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