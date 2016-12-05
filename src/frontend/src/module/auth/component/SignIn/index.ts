import {Component, Output, EventEmitter, ViewChild, ElementRef} from "@angular/core";

import {AuthService} from "../../service/AuthService";
import {SignInRequest, SignInResponse200} from "../../definitions/paths/sign-in";
import {LoadingManager} from "../../../common/classes/LoadingStatus";
import {Router} from "@angular/router";
import {FormInput} from "../../../form/component/FormInput/index";

@Component({
    selector: 'cass-auth-sign-in',
    template: require('./template.jade')
})
export class SignInComponent
{
    @ViewChild('input') input: FormInput;

    @Output('success') successEvent = new EventEmitter();
    @Output('close') closeEvent = new EventEmitter<SignInModel>();
    @Output('sign-up') signUpEvent = new EventEmitter<SignInModel>();

    private status: LoadingManager = new LoadingManager();

    private model: SignInModel = {
        email: '',
        password: ''
    };

    constructor(
        private service: AuthService,
        private router: Router
    ) {}

    ngAfterViewInit() {
        this.input.putFocus();
    }

    submit() {
        let loading = this.status.addLoading();

        this.service.signIn(this.model).subscribe(
            (response: SignInResponse200) => {
                if (this.service.isSignedIn()) {
                    this.router.navigate(['/profile/current']);
                    this.successEvent.emit(response);
                }

                loading.is = false;
            },
            error => {
                loading.is = false;
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