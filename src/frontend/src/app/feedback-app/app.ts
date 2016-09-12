import {ModuleWithProviders, OnInit, OnDestroy, Component} from "@angular/core";
import {Router, Routes, RouterModule, ActivatedRoute} from '@angular/router';

import {AuthComponent} from "../../module/auth/component/Auth/index";
import {AuthComponentService} from "../../module/auth/component/Auth/service";
import {AuthService} from "../../module/auth/service/AuthService";
import {AuthRESTService} from "../../module/auth/service/AuthRESTService";
import {AccountService} from "../../module/account/service/AccountService";
import {AccountRESTService} from "../../module/account/service/AccountRESTService";
import {ModalService} from "../../module/modal/component/service";
import {HeadMenuComponent} from "./src/module/head-menu/index";
import {FeedbackRoute} from "./src/module/feedback/route/FeedbackRoute/index";
import {MessageBusService} from "../../module/message/service/MessageBusService/index";
import {MessageBusNotifications} from "../../module/message/component/MessageBusNotifications/index";

const feedbackAdminRoutes: Routes = [
    // TODO:: USE AS DEFAULT
    {
        path: '/feedback-admin/...',
        component: FeedbackRoute,
    }
];

export const feedbackAdminRouting: ModuleWithProviders = RouterModule.forChild(feedbackAdminRoutes);

@Component({
    selector: 'cass-feedback-bootstrap',
    template: require('./template.jade')
})


export class App {
    constructor(private authService: AuthService) {
        // Do not(!) remove authService dependency.
    }
}