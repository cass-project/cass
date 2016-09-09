import {Component, ModuleWithProviders} from "@angular/core";
import {Routes, RouterModule, RouterOutlet} from '@angular/router';
import {CommunityCollectionsListRoute} from "../CommunityCollectionsListRoute/index";
import {CommunityCollectionRoute} from "../CommunityCollectionRoute/index";
import {CommunityCollectionNotFoundRoute} from "../CommunityCollectionNotFoundRoute/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
const communityCollectionsRoutes: Routes = [
    {
        path: '/',
        name: 'List',
        component: CommunityCollectionsListRoute,
        useAsDefault: true
    },
    {
        path: '/not-found',
        name: 'NotFound',
        component: CommunityCollectionNotFoundRoute
    },
    {
        path: '/:sid',
        name: 'View',
        component: CommunityCollectionRoute
    },
];

export const communityCollectionsRouting: ModuleWithProviders = RouterModule.forChild(communityCollectionsRoutes);

export class CommunityCollectionsRoute
{
    
}