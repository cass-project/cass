import {Component} from 'angular2/core';
import {AuthService} from './../../service/AuthService';
import {OAuth2Component} from '../OAuth2Component/index';

@Component({
    template: require('./template.html'),
    directives: [
        OAuth2Component
    ]
})

export class SignUpComponent{
    email:string;
    phone:string;
    password:string;
    passwordAgain:string;

    constructor(public authService: AuthService){}

    attemptSignUp(){
        this.authService.attemptSignUp({
            email: this.email,
            password: this.password,
            repeat: this.passwordAgain
        });
    }
}