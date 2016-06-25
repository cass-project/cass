import {Component, Output, EventEmitter} from "angular2/core";

import {OAuth2Component} from "../OAuth2/index";
import {MessageBusService} from "../../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../message/component/MessageBusNotifications/model";
import {LoadingIndicator} from "../../../form/component/LoadingIndicator/index";
import {AuthRESTService} from "../../service/AuthRESTService";
import {AuthService} from "../../service/AuthService";
import {SignInRequest} from "../../definitions/paths/sign-in";

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

    @Output('success') successEvent = new EventEmitter();
    @Output('close') closeEvent = new EventEmitter<SignInModel>();
    @Output('sign-up') signUpEvent = new EventEmitter<SignInModel>();

    constructor(
        private service: AuthService,
        private messages: MessageBusService
    ) {}

    submit() {
        this.status.loading = true;

        this.service.signIn(this.model).map(res => res.json()).subscribe(
            response => {
                if(AuthService.isSignedIn()) {
                    this.successEvent.emit(response);
                }

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

interface SignInModel extends SignInRequest
{
    email: string;
    password: string;
}

interface SignInStatus
{
    loading: boolean;
}