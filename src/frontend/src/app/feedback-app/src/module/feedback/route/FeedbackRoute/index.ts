import {Component} from "@angular/core";
import {RouterOutlet} from '@angular/router-deprecated';
import {RouteConfig} from '@angular/router-deprecated'

import {FeedbackComponent} from "../../index";
import {AccessDeniedComponent} from "../../../access-denied/index";

@Component({
    template: require('./template.jade'),
    directives: [
        RouterOutlet
    ]
})

@RouteConfig([
    {
        name: 'Feedback',
        path: '/',
        component: FeedbackComponent,
        useAsDefault: true
    },
    {
        name: 'FeedbackPage',
        path: '/page/:page',
        component: FeedbackComponent,
    },
    {
        name: 'AccessDenied',
        path: '/access-denied',
        component: AccessDeniedComponent,
    },
])

export class FeedbackRoute {}