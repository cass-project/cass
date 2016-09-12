import {Component, ModuleWithProviders} from "@angular/core";
import {Routes, RouterModule, RouterOutlet} from '@angular/router';
import {Nothing} from "../../../common/component/Nothing/index";
import {ProfileRoute} from "../ProfileRoute/index";
import {ProfileNotFoundRoute} from "../ProfileNotFoundRoute/index";

const profileRootRoutes: Routes = [
    // TODO:: USE AS DEFAULT
    {
        path: '/',
        component: Nothing,
    },
    {
        path: '/:id/...',
        component: ProfileRoute
    },
    {
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