import {Component} from 'angular2/core';
import {Router} from 'angular2/router';
import {AuthService} from './../../service/AuthService';
import {OAuth2Component} from '../OAuth2/index';

@Component({
    template: require('./template.html'),
    directives: [
        OAuth2Component
    ]
})

export class SignUpComponent{
    private loading = false;

    private model = {
        email: "",
        password: "",
        repeat: "",
        remember: false
    };

    constructor(private authService: AuthService, private router: Router){}

    attemptSignUp() {
        this.loading = true;
        this.model.remember = true;

        this.authService.attemptSignUp(this.model).add(() => {
            if(!this.authService.lastError) {
                this.router.navigate(['/']);
            }

            this.loading = false;
        });
    }

    attemptSignUpNoRemember() {
        this.loading = true;
        this.model.remember = false;

        this.authService.attemptSignUp(this.model).add(() => {
            if(!this.authService.lastError) {
                this.router.navigate(['/']);
            }

            this.loading = false;
        });
    }
}