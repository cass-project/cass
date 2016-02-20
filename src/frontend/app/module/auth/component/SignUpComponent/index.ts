import {Component} from 'angular2/core';
import {AuthService, AuthServiceProvider} from './../../service/AuthService';

@Component({
    template: require('./template.html'),
})

export class SignUpComponent{
    email:string;
    phone:string;
    password:string;
    passwordAgain:string;
    authService:AuthService;

    constructor(authServiceProvider:AuthServiceProvider){
        this.authService = authServiceProvider.getInstance();
    }

    attemptSignUp(){
        this.authService.attemptSignUp(this.email, this.phone, this.password, this.passwordAgain);
    }


}