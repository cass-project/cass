import {Component, ModuleWithProviders} from "@angular/core";
import {Routes, RouterModule, RouterOutlet} from '@angular/router';
import {Nothing} from "../../../common/component/Nothing/index";
import {ProfileRoute} from "../ProfileRoute/index";
import {ProfileNotFoundRoute} from "../ProfileNotFoundRoute/index";

const profileRootRoutes: Routes = [
    {
        name: 'Root',
        path: '/',
        component: Nothing,
        useAsDefault: true
    },
    {
        name: 'Profile',
        path: '/:id/...',
        component: ProfileRoute
    },
    {
        name: 'NotFound',
        path: '/not-found',
        component: ProfileNotFoundRoute
    },
];

export const profileRootRouting: ModuleWithProviders = RouterModule.forChild(profileRootRoutes);

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class ProfileRootRoute
{
}