import {Component, Output, EventEmitter} from "angular2/core";

import {OAuth2Component} from "../OAuth2/index";
import {AuthService, SignInResponse} from "../../service/AuthService";
import {MessageBusService} from "../../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../message/component/MessageBusNotifications/model";
import {LoadingIndicator} from "../../../form/component/LoadingIndicator/index";

@Component({
    template: require('./template.jade'),
    selector: 'cass-auth-sign-in',
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        OAuth2Component,
        LoadingIndicator
    ]
})
export class SignInComponent
{
    private status: SignInStatus = {
        loading: false
    };

    private model: SignInModel = {
        email: '',
        password: ''
    };

    @Output('success') successEvent = new EventEmitter<SignInResponse>();
    @Output('close') closeEvent = new EventEmitter<SignInModel>();
    @Output('sign-up') signUpEvent = new EventEmitter<SignInModel>();

    constructor(
        private authService: AuthService,
        private messages: MessageBusService
    ) {}


    submit() {
        this.status.loading = true;

        this.authService.attemptSignIn(this.model).subscribe(
            response =>{
                this.successEvent.emit(response);
                this.status.loading = false;
            },
            error => {this.messages.push(MessageBusNotificationsLevel.Warning, error);
                this.status.loading = false;
            });
    }

    signUp(){
        this.signUpEvent.emit(this.model);
    }

    close() {
        this.closeEvent.emit(this.model);
    }
}

interface SignInModel
{
    email: string;
    password: string;
}

interface SignInStatus
{
    loading: boolean;
}