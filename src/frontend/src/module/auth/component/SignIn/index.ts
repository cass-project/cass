import {Component, Output, EventEmitter, ViewChild, ElementRef, Directive} from "@angular/core";


import {AuthService} from "../../service/AuthService";
import {SignInRequest, SignInResponse200} from "../../definitions/paths/sign-in";


@Component({
    template: require('./template.jade')
})
@Directive({selector: 'cass-auth-sign-in'})
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

        this.service.signIn(this.model).subscribe(
            (response: SignInResponse200) => {
                if (this.service.isSignedIn()) {
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