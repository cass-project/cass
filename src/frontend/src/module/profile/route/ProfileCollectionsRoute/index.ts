import {Component, ModuleWithProviders} from "@angular/core";
import {Routes, RouterModule, RouterOutlet} from '@angular/router';

import {ProfileCollectionsListRoute} from "../ProfileCollectionsListRoute/index";
import {ProfileCollectionRoute} from "../ProfileCollectionRoute/index";
import {ProfileCollectionNotFoundRoute} from "../ProfileCollectionNotFoundRoute/index";

const profileCollectionRoutes: Routes = [
    {
        path: '/',
        name: 'List',
        component: ProfileCollectionsListRoute,
        useAsDefault: true
    },
    {
        path: '/not-found',
        name: 'NotFound',
        component: ProfileCollectionNotFoundRoute
    },
    {
        path: '/:sid',
        name: 'View',
        component: ProfileCollectionRoute
    },
];

export const profileCollectionRouting: ModuleWithProviders = RouterModule.forChild(profileCollectionRoutes);

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class ProfileCollectionsRoute
{

}