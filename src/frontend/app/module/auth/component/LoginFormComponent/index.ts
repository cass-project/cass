import {Component} from 'angular2/core';
import {AuthService, AuthServiceProvider} from './../../service/AuthService';

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    selector: 'login-form',
    providers: [AuthService, AuthServiceProvider]
})


export class LoginFormComponent{
    login:string;
    password:string;
    authService:AuthService;

    constructor(authServiceProvider:AuthServiceProvider){
         this.authService = authServiceProvider.getInstance();
    }

    attemptSignIn(){
        var isSigned:boolean = this.authService.attemptSignIn(this.login,this.password);
    }
}