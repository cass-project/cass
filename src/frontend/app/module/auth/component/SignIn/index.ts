import {Component} from "angular2/core";
import {Router} from 'angular2/router';
import {OAuth2Component} from "../OAuth2/index";
import {LoadingIndicator} from "../../../util/component/LoadingIndicator/index";
import {AuthComponentService} from "../Auth/service";
import {AuthService} from "../../service/AuthService";

@Component({
    /*
        Замени template-stages.html на template.html
        template-stages содержит всю разработанную для компонента верстку
        template же должен быть рабочим вариантом
     */
    template: require('./template-stages.html'),
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
    private loading = false;
    private personalInfo = {
        email: "",
        password: "",
        remember: false,
    };

    constructor(private authService: AuthService, private service: AuthComponentService, private router: Router){}

    attemptSignIn(){
        this.loading = true;
        this.personalInfo.remember = true;

        this.authService.attemptSignIn(this.personalInfo).add(() => {
            this.loading = false;

            if(!this.authService.lastError) {
                this.router.navigate(['/']);
            }
        });
    }

    attemptSignInNoRemember() {
        this.loading = true;
        this.personalInfo.remember = false;

        this.authService.attemptSignIn(this.personalInfo).add(() => {
            this.loading = false;

            if(!this.authService.lastError) {
                this.router.navigate(['/']);
            }
        });
    }

    createNewAccount(){
        this.service.modals.closeModals();
        this.service.modals.openSignUpModal();
    }
}