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
    template: require('./template.html'),
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
        password: ""
    };

    checkEmail(){
        let regexp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return regexp.test(this.personalInfo.email);
    }

    constructor(private authService: AuthService, private service: AuthComponentService, private router: Router){}

    attemptSignIn(){
        this.loading = true;

        this.authService.attemptSignIn(this.personalInfo).add(data => {
            if(!this.authService.lastError) {
                this.service.modals.closeModals();
                this.router.navigate(['/']);
            }
            this.loading = false;
        })
    }

    createNewAccount(){
        this.service.modals.closeModals();
        this.service.modals.openSignUpModal();
    }
}