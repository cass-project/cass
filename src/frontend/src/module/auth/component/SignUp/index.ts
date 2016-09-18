import {Component, Output, EventEmitter, ElementRef, ViewChild} from "@angular/core";

import {SignInRequest} from "../../definitions/paths/sign-in";
import {SignUpRequest} from "../../definitions/paths/sign-up";
import {AuthService} from "../../service/AuthService";
import {LoadingManager} from "../../../common/classes/LoadingStatus";

@Component({
    selector: 'cass-auth-sign-up',
    template: require('./template.jade')
})

export class SignUpComponent
{
    @ViewChild('emailInput') emailInput: ElementRef;
    
    @Output('back') backEvent = new EventEmitter<SignInRequest>();
    @Output('close') closeEvent = new EventEmitter<SignUpRequest>();
    @Output('success') successEvent = new EventEmitter();

    private status: LoadingManager = new LoadingManager();
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
        let loading = this.status.addLoading();

        this.authService.signUp(this.model).subscribe(
            response =>{
                this.successEvent.emit(response);
                loading.is = false;
            },
            () => {
                loading.is = false;
            });
    }

    isSubmitAvailable(): boolean {
        let testHasEmail = this.model.email.length > 0;
        let testHasPassword = this.model.password.length > 0;
        let testPasswordMatches = this.model.password === this.model.repeat;
        let testNotIsLoading = this.status.isLoading();

        return !! (testNotIsLoading && testHasEmail && testHasPassword && testPasswordMatches);
    }

    close() {
        this.closeEvent.emit(this.model);
    }

    back() {
        this.backEvent.emit(this.model);
    }
}