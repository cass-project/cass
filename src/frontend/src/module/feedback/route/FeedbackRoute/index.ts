import {Component} from "angular2/core";
import {RouterOutlet, RouteConfig} from "angular2/router";

import {FeedbackCreateRoute} from "../FeedbackCreateRoute/index";
import {FeedbackCreateModalModel} from "../../component/Modal/FeedbackCreateModal/model";
import {FeedbackService} from "../../service/FeedbackService";
import {FeedbackRESTService} from "../../service/FeedbackRESTService";
import {FeedbackTypesService} from "../../service/FeedbackTypesService";

@Component({
    selector: "feedback-router",
    template: require('./template.jade'),
    directives: [
        RouterOutlet
    ],
    providers:[
        FeedbackCreateModalModel,
        FeedbackService,
        FeedbackRESTService,
        FeedbackTypesService
    ]
})

@RouteConfig([
    {
        name: 'FeedbackCreate',
        path: '/create',
        component: FeedbackCreateRoute,
        useAsDefault: true
    },
    {
        name: 'FeedbackCreateType',
        path: '/create/:type',
        component: FeedbackCreateRoute,
    },
])

export class FeedbackRoute {}