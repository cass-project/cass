import {Component, ModuleWithProviders} from "@angular/core";
import {Routes, RouterModule, RouterOutlet} from '@angular/router';
import {Nothing} from "../../../common/component/Nothing/index";
import {CommunityRoute} from "../CommunityRoute/index";
import {CommunityNotFoundRoute} from "../CommunityNotFoundRoute/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        RouterOutlet,
    ],
})
const communityRootRoutes: Routes =[
    {
        name: 'Root',
        path: '/',
        component: Nothing,
        useAsDefault: true
    },
    {
        name: 'Community',
        path: '/:sid/...',
        component: CommunityRoute
    },
    {
        name: 'NotFound',
        path: '/not-found',
        component: CommunityNotFoundRoute
    },
];

export const communityRootRouting: ModuleWithProviders = RouterModule.forChild(communityRootRoutes);

export class CommunityRootRoute
{
}