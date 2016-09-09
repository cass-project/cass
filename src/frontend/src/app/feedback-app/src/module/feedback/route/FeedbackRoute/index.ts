import {Component, ModuleWithProviders} from "@angular/core";
import {Router, Routes, RouterModule, ActivatedRoute} from '@angular/router';

import {FeedbackComponent} from "../../index";
import {AccessDeniedComponent} from "../../../access-denied/index";

const feedbackRoutes: Routes = [
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
];

export const feedbackRouting: ModuleWithProviders = RouterModule.forChild(feedbackRoutes);

@Component({
    template: require('./template.jade')
})

export class FeedbackRoute {}