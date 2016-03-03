import {Component} from 'angular2/core';
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
    login:string;
    password:string;

    constructor(public authService: AuthService){}

    attemptSignIn(){
        this.authService.attemptSignIn(this.login,this.password);
    }
}