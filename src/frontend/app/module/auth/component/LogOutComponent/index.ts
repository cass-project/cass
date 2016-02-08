import {Component} from 'angular2/core';

import {AuthService, AuthServiceProvider} from './../../service/AuthService';
import {SignInComponent} from './../SignInComponent/index';

@Component({
    template: require('./template.html'),
    providers:[AuthServiceProvider]
})


export class LogOutComponent
{
    authService:AuthService;

    constructor(authServiceProvider:AuthServiceProvider){
        this.authService = authServiceProvider.getInstance();
        this.authService.logOut();
    }


}