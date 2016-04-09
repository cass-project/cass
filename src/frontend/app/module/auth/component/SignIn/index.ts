import {Component} from 'angular2/core';
import {Router} from 'angular2/router';
import {OAuth2Component} from '../OAuth2/index';
import {AuthService} from './../../service/AuthService';
import {ROUTER_DIRECTIVES} from "angular2/router";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        OAuth2Component,
        ROUTER_DIRECTIVES
    ]
})
export class SignInComponent{
    private loading = false;
    private model = {
        email: "",
        password: "",
        remember: false,
    };

    constructor(private authService: AuthService, private router: Router){}

    attemptSignIn(){
        this.loading = true;
        this.model.remember = true;

        this.authService.attemptSignIn(this.model).add(() => {
            this.loading = false;

            if(!this.authService.lastError) {
                this.router.navigate(['/Welcome']);
            }
        });
    }

    attemptSignInNoRemember() {
        this.loading = true;
        this.model.remember = false;

        this.authService.attemptSignIn(this.model).add(() => {
            this.loading = false;

            if(!this.authService.lastError) {
                this.router.navigate(['/Welcome']);
            }
        });
    }
}