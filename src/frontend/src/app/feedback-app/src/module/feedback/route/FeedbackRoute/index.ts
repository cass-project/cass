import {Component} from "angular2/core";
import {RouterOutlet, RouteConfig} from "angular2/router";
import {FeedbackComponent} from "../../index";
import {AccessDeniedComponent} from "../../component/Elements/FeedbackAccessDeniedComponent/index";

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
        name: 'AccessDenied',
        path: '/access-denied',
        component: AccessDeniedComponent,
    },
])

export class FeedbackRoute {}