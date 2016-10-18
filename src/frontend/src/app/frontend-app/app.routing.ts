import {ModuleWithProviders} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';

import {ProfileRoute} from "../../module/profile/route/ProfileRoute/index";
import {CommunityRoute} from "../../module/community/route/CommunityRoute/index";
import {ProfileNotFoundRoute} from "../../module/profile/route/ProfileNotFoundRoute/index";
import {ProfileDashboardRoute} from "../../module/profile/route/ProfileDashboardRoute/index";
import {ProfileCollectionsRoute} from "../../module/profile/route/ProfileCollectionsRoute/index";
import {ProfileCollectionsListRoute} from "../../module/profile/route/ProfileCollectionsListRoute/index";
import {ProfileCollectionNotFoundRoute} from "../../module/profile/route/ProfileCollectionNotFoundRoute/index";
import {ProfileCollectionRoute} from "../../module/profile/route/ProfileCollectionRoute/index";
import {CommunityNotFoundRoute} from "../../module/community/route/CommunityNotFoundRoute/index";
import {CommunityCollectionsListRoute} from "../../module/community/route/CommunityCollectionsListRoute/index";
import {CommunityCollectionNotFoundRoute} from "../../module/community/route/CommunityCollectionNotFoundRoute/index";
import {CommunityCollectionRoute} from "../../module/community/route/CommunityCollectionRoute/index";
import {ProfileResolve} from "../../module/profile/resolve/ProfileResolve";
import {ContentRoute} from "../../module/public/route/sources/ContentRoute/index";
import {ProfilesRoute} from "../../module/public/route/sources/ProfilesRoute/index";
import {CollectionsRoute} from "../../module/public/route/sources/CollectionsRoute/index";
import {CommunitiesRoute} from "../../module/public/route/sources/CommunitiesRoute/index";
import {CommunityResolve} from "../../module/community/resolve/CommunityResolve";

const appRoutes: Routes = [
    {
        path: '',
        redirectTo: '/p/home',
        pathMatch: 'full'
    },
    {
        path: 'profile',
        children: [
            {
                path: '',
                redirectTo: 'current',
                pathMatch: 'full'
            },
            {
                path: ':id',
                component: ProfileRoute,
                resolve: {
                    profile: ProfileResolve
                },
                children: [
                    {
                        path: '',
                        component: ProfileDashboardRoute
                    },
                    {
                        path: 'collections',
                        component: ProfileCollectionsRoute,
                        children: [
                            {
                                path: '',
                                component: ProfileCollectionsListRoute,
                            },
                            {
                                path: 'not-found',
                                component: ProfileCollectionNotFoundRoute
                            },
                            {
                                path: ':sid',
                                pathMatch: 'full',
                                component: ProfileCollectionRoute
                            }
                        ]
                    }
                ]
            },
            {
                path: '/not-found',
                component: ProfileNotFoundRoute
            }
        ]
    },
    {
        path: 'community',
        children: [
            {
                path: '',
                redirectTo: 'not-found',
                pathMatch: 'full'
            },
            {
                path: ':sid',
                component: CommunityRoute,
                resolve: {
                    community: CommunityResolve
                },
                children: [
                    {
                        path: '',
                        component: CommunityCollectionsListRoute,
                    },
                    {
                        path: 'not-found',
                        component: CommunityCollectionNotFoundRoute
                    },
                    {
                        path: ':sid',
                        component: CommunityCollectionRoute
                    }
                ]
            },
            {
                path: 'not-found',
                component: CommunityNotFoundRoute
            }
        ]
    },
    {
        path: 'p',
        children: [
            {
                path: '',
                component: ContentRoute
            },
            {
                path: 'home',
                component: ContentRoute
            },
            {
                path: 'people',
                component: ProfilesRoute
            },
            {
                path: 'collections',
                component: CollectionsRoute
            },
            {
                path: 'communities',
                component: CommunitiesRoute
            },
        ]
    }
];

export const appRoutingProviders: any[] = [];

export const routing: ModuleWithProviders = RouterModule.forRoot(appRoutes);