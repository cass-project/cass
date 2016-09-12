import {ModuleWithProviders} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {ProfileRoute} from "../../module/profile/route/ProfileRoute/index";
import {CommunityRoute} from "../../module/community/route/CommunityRoute/index";
import {PublicComponent} from "../../module/public/index";

const appRoutes: Routes = [
    {
        path: '**', redirectTo: '/public'
    },
    {
        path: 'profile/:id',
        component: ProfileRoute
    },
    {
        path: 'community/:sid',
        component: CommunityRoute
    },
    {
        path: 'public',
        component: PublicComponent
    },
];

export const appRoutingProviders: any[] = [];

export const routing: ModuleWithProviders = RouterModule.forRoot(appRoutes);