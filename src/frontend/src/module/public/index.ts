import {Component, ModuleWithProviders} from "@angular/core";
import {Routes, RouterModule} from "@angular/router";

import {ContentRoute} from "./route/ContentRoute/index";
import {PublicService} from "./service";
import {CollectionsRoute} from "./route/CollectionsRoute/index";
import {CommunitiesRoute} from "./route/CommunitiesRoute/index";
import {ExpertsRoute} from "./route/ExpertsRoute/index";
import {ProfilesRoute} from "./route/ProfilesRoute/index";
import {FeedCriteriaService} from "../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../feed/service/FeedOptionsService";
import {AppService} from "../../app/frontend-app/service";

const publicRoutes: Routes = [
    {
        path: '/content',
        component: ContentRoute
    },
    {
        path: '/collections',
        component: CollectionsRoute
    },
    {
        path: '/communities',
        component: CommunitiesRoute
    },
    {
        path: '/experts',
        component: ExpertsRoute
    },
    {
        path: '/profiles',
        component: ProfilesRoute
    },
];

export const publicRouting: ModuleWithProviders = RouterModule.forChild(publicRoutes);

@Component({
    selector: 'cass-public',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        PublicService,
        FeedCriteriaService,
        FeedOptionsService,
    ]
})

export class PublicComponent
{
    constructor(private service: PublicService,
                private appService: AppService) {}

    onScroll($event){
        this.appService.onScroll($event)
    }

    isPostCriteriaAvailable() {
        return ~[
            "content",
        ].indexOf(this.service.source);
    }
}
