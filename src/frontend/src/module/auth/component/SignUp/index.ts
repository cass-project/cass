import {Component, Output, EventEmitter, ElementRef, ViewChild, Directive} from "@angular/core";

import {OAuth2Component} from "../OAuth2/index";
import {LoadingIndicator} from "../../../form/component/LoadingIndicator/index";
import {SignInRequest} from "../../definitions/paths/sign-in";
import {SignUpRequest} from "../../definitions/paths/sign-up";
import {ProgressLock} from "../../../form/component/ProgressLock/index";
import {NgForm} from "@angular/forms";
import {AuthService} from "../../service/AuthService";

@Component({
    template: require('./template.jade')
})
@Directive({selector: 'cass-auth-sign-up'})
export class SignUpComponent
{
    @ViewChild('form') form: NgForm;
    @ViewChild('emailInput') emailInput: ElementRef;
    
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

    constructor(private authService: AuthService) {}

    ngAfterViewInit() {
        this.emailInput.nativeElement.focus();
    }

    submit() {
        this.status.loading = true;

        this.authService.signUp(this.model).subscribe(
            response =>{
                this.successEvent.emit(response);
                this.status.loading = false;
            },
            () => {
                this.status.loading = false;
            });
    }

    isSubmitAvailable(): boolean {
        let testHasEmail = this.model.email.length > 0;
        let testHasPassword = this.model.password.length > 0;
        let testPasswordMatches = this.model.password === this.model.repeat;
        let testNotIsLoading = this.status.loading === false;

        return !! (testNotIsLoading && testHasEmail && testHasPassword && testPasswordMatches);
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