import {Component, ModuleWithProviders} from "@angular/core";
import {Routes, RouterModule, RouterOutlet} from '@angular/router';
import {Nothing} from "../../../common/component/Nothing/index";
import {CommunityRoute} from "../CommunityRoute/index";
import {CommunityNotFoundRoute} from "../CommunityNotFoundRoute/index";

const communityRootRoutes: Routes =[
    // TODO:: USE AS DEFAULT
    {
        path: '/',
        component: Nothing,
    },
    {
        path: '/:sid/...',
        component: CommunityRoute
    },
    {
        path: '/not-found',
        component: CommunityNotFoundRoute
    },
];

export const communityRootRouting: ModuleWithProviders = RouterModule.forChild(communityRootRoutes);


@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class CommunityRootRoute
{
}