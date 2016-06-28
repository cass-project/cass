import {Component, Output, EventEmitter, ViewChild, ElementRef} from "angular2/core";

import {OAuth2Component} from "../OAuth2/index";
import {LoadingIndicator} from "../../../form/component/LoadingIndicator/index";
import {AuthService} from "../../service/AuthService";
import {SignInRequest, SignInResponse200} from "../../definitions/paths/sign-in";
import {ProgressLock} from "../../../form/component/ProgressLock/index";

@Component({
    template: require('./template.jade'),
    selector: 'cass-auth-sign-in',
    directives: [
        OAuth2Component,
        LoadingIndicator,
        ProgressLock
    ]
})
export class SignInComponent
{
    @ViewChild('emailInput') emailInput: ElementRef;

    @Output('success') successEvent = new EventEmitter();
    @Output('close') closeEvent = new EventEmitter<SignInModel>();
    @Output('sign-up') signUpEvent = new EventEmitter<SignInModel>();

    private status: SignInStatus = {
        loading: false
    };

    private model: SignInModel = {
        email: '',
        password: ''
    };

    constructor(private service: AuthService) {}

    ngAfterViewInit() {
        this.emailInput.nativeElement.focus();
    }

    submit() {
        this.status.loading = true;

        this.service.signIn(this.model).map(res => res.json()).subscribe(
            (response: SignInResponse200) => {
                if (AuthService.isSignedIn()) {
                    this.successEvent.emit(response);
                }

                this.status.loading = false;
            },
            error => {
                this.status.loading = false;
            });
    }

    signUp() {
        this.signUpEvent.emit(this.model);
    }

    close() {
        this.closeEvent.emit(this.model);
    }
}

interface SignInModel extends SignInRequest {
    email: string;
    password: string;
}

interface SignInStatus {
    loading: boolean;
}