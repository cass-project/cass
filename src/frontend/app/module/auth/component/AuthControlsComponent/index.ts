import {Component} from 'angular2/core';
import {ROUTER_DIRECTIVES} from 'angular2/router';
import {COMMON_DIRECTIVES} from 'angular2/common';
import {AuthService} from './../../service/AuthService';

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    selector: 'auth-controls',
    directives: [
        COMMON_DIRECTIVES,
        ROUTER_DIRECTIVES
    ]
})


export class AuthControlsComponent
{
    constructor(public authService: AuthService) {}
}
