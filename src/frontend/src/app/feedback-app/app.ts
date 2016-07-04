import {Component} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
import {RouteConfig, ROUTER_DIRECTIVES, RouterOutlet} from "angular2/router";

import {AuthComponent}        from "../../module/auth/component/Auth/index";
import {AuthComponentService} from "../../module/auth/component/Auth/service";
import {AuthService}          from "../../module/auth/service/AuthService";
import {AuthRESTService}      from "../../module/auth/service/AuthRESTService";
import {AccountService}       from "../../module/account/service/AccountService";
import {AccountRESTService}   from "../../module/account/service/AccountRESTService";
import {ModalService}         from "../../module/modal/component/service";
import {HeadMenuComponent}    from "./src/module/head-menu/index";
import {FeedbackRoute}        from "./src/module/feedback/route/FeedbackRoute/index";

@Component({
    selector: 'cass-feedback-bootstrap',
    template: require('./template.jade'),
    providers: [
        AuthComponentService,
        AuthService,
        AuthRESTService,
        AccountService,
        AccountRESTService,
        ModalService
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CORE_DIRECTIVES,
        RouterOutlet,
        HeadMenuComponent,
        AuthComponent
    ]
})

@RouteConfig([
    {
        name: 'FeedbackRoute',
        path: '/feedback-admin/...',
        component: FeedbackRoute,
        useAsDefault: true
    }
])


export class App {
    constructor(private authService: AuthService) {
        // Do not(!) remove authService dependency.
    }
}