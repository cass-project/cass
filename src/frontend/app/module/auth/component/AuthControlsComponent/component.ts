import {Component} from 'angular/core';
import {AuthService} from './../../service/AuthService';

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],

})
class AuthControlsComponent
{
    auth: AuthService;

    constructor(auth: AuthService) {
        this.auth = auth;
    }

    isAuthenticated() {
        return this.auth.isAuthenticated();
    }
}