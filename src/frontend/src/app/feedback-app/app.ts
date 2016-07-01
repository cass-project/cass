import {Component} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
import {RouteConfig, ROUTER_DIRECTIVES, RouterOutlet} from "angular2/router";

import {IndexComponent} from "./src/module/landing";
import {AuthService} from "../../module/auth/service/AuthService";
import {AuthRESTService} from "../../module/auth/service/AuthRESTService";
import {MessageBusService} from "../../module/message/service/MessageBusService/index";


function isLoggedIn() {
    return true;
}

@Component({
    selector: 'cass-feedback-bootstrap',
    template: require('./template.jade'),
    providers: [
        AuthService,
        AuthRESTService,
        MessageBusService
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CORE_DIRECTIVES,
        RouterOutlet
    ]
})

@RouteConfig([
    {
        name: 'Index',
        path: '/welcome',
        component: IndexComponent,
        useAsDefault: true
    }
])


//@CanActivate(() => isLoggedIn())
export class App {
    constructor(private authService: AuthService) {
        // Do not(!) remove authService dependency.
    }
}