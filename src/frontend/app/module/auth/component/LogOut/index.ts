import {Component} from 'angular2/core';
import {Router} from 'angular2/router';

import {AuthService} from './../../service/AuthService';
import {SignInComponent} from './../SignIn/index';

@Component({
    template: require('./template.html')
})


export class LogOutComponent
{
    constructor(public authService: AuthService) {}

    ngOnInit() {
        this.authService.signOut();
    }
}