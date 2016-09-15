import {ModuleWithProviders} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {ProfileRoute} from "../../module/profile/route/ProfileRoute/index";
import {CommunityRoute} from "../../module/community/route/CommunityRoute/index";
import {PublicComponent} from "../../module/public/index";
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
import {ContentRoute} from "../../module/public/route/ContentRoute/index";
import {CollectionsRoute} from "../../module/public/route/CollectionsRoute/index";
import {CommunitiesRoute} from "../../module/public/route/CommunitiesRoute/index";
import {ExpertsRoute} from "../../module/public/route/ExpertsRoute/index";
import {ProfilesRoute} from "../../module/public/route/ProfilesRoute/index";

const appRoutes: Routes = [
    {
        path: '',
        redirectTo: 'public',
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
        path: 'public',
        children: [
            {
                path: '',
                component: PublicComponent,
            },
            {
                path: 'content',
                component: ContentRoute
            },
            {
                path: 'collections',
                component: CollectionsRoute
            },
            {
                path: 'communities',
                component: CommunitiesRoute
            },
            {
                path: 'experts',
                component: ExpertsRoute
            },
            {
                path: 'profiles',
                component: ProfilesRoute
            }
        ]
    },
];

export const appRoutingProviders: any[] = [];

export const routing: ModuleWithProviders = RouterModule.forRoot(appRoutes);