import {Component, ModuleWithProviders} from "@angular/core";
import {Routes, RouterModule, RouterOutlet} from '@angular/router';
import {CommunityCollectionsListRoute} from "../CommunityCollectionsListRoute/index";
import {CommunityCollectionRoute} from "../CommunityCollectionRoute/index";
import {CommunityCollectionNotFoundRoute} from "../CommunityCollectionNotFoundRoute/index";

const communityCollectionsRoutes: Routes = [
    // TODO:: USE AS DEFAULT
    {
        path: '/',
        component: CommunityCollectionsListRoute,
    },
    {
        path: '/not-found',
        component: CommunityCollectionNotFoundRoute
    },
    {
        path: '/:sid',
        component: CommunityCollectionRoute
    },
];

export const communityCollectionsRouting: ModuleWithProviders = RouterModule.forChild(communityCollectionsRoutes);

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityCollectionsRoute
{
}