import {Component} from 'angular2/core';
import {Router} from 'angular2/router';
import {OAuth2Component} from '../OAuth2Component/index';
import {AuthService} from './../../service/AuthService';

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        OAuth2Component
    ]
})
export class SignInComponent{
    private loading = false;
    private model = {
        email: "",
        password: ""
    };

    constructor(private authService: AuthService, private router: Router){}

    attemptSignIn(){
        this.loading = true;
        this.authService.attemptSignIn({
            email: this.model.email,
            password: this.model.password,
            remember: true
        }).add(() => {
            this.loading = false;
            this.router.navigate(['/Welcome']);
        });
    }

    attemptSignInNoRemember() {
        this.loading = true;
        this.authService.attemptSignIn({
            email: this.model.email,
            password: this.model.password,
            remember: false
        }).add(() => {
            this.loading = false;
            this.router.navigate(['/Welcome']);
        });
    }
}