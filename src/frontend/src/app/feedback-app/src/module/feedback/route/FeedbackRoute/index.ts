import {Component, ModuleWithProviders} from "@angular/core";
import {Router, Routes, RouterModule, ActivatedRoute} from '@angular/router';

import {FeedbackComponent} from "../../index";
import {AccessDeniedComponent} from "../../../access-denied/index";

const feedbackRoutes: Routes = [
    // TODO:: USE AS DEFAULT
    {
        path: '/',
        component: FeedbackComponent,
    },
    {
        path: '/page/:page',
        component: FeedbackComponent,
    },
    {
        path: '/access-denied',
        component: AccessDeniedComponent,
    },
];

export const feedbackRouting: ModuleWithProviders = RouterModule.forChild(feedbackRoutes);

@Component({
    template: require('./template.jade')
})

export class FeedbackRoute {}