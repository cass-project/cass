import {Component} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
import {RouteConfig, ROUTER_DIRECTIVES, RouterOutlet} from "angular2/router";

import {LandindComponent} from "./src/module/landing";
import {AuthService} from "../../module/auth/service/AuthService";
import {AuthRESTService} from "../../module/auth/service/AuthRESTService";
import {MessageBusService} from "../../module/message/service/MessageBusService/index";
import {AccountService} from "../../module/account/service/AccountService";
import {AccountRESTService} from "../../module/account/service/AccountRESTService";

@Component({
    selector: 'cass-feedback-bootstrap',
    template: require('./template.jade'),
    providers: [
        AuthService,
        AuthRESTService,
        AccountService,
        AccountRESTService,
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
        name: 'Landing',
        path: '/feedback-admin',
        component: LandindComponent,
        useAsDefault: true
    }
])


export class App {
    private isAdmin:boolean;
    constructor(
        private authService: AuthService,
        private accountService: AccountService
    ) {
        // Do not(!) remove authService dependency.
        accountService.appAccess().subscribe( data => {
            this.isAdmin = data.access.apps.feedback;
        })
    }
}