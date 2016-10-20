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
import {ContentGatewayRoute} from "../../module/public/route/sources/ContentRoute/index";
import {ProfilesRoute} from "../../module/public/route/sources/ProfilesRoute/index";
import {CollectionsRoute} from "../../module/public/route/sources/CollectionsRoute/index";
import {CommunitiesRoute} from "../../module/public/route/sources/CommunitiesRoute/index";
import {CommunityResolve} from "../../module/community/resolve/CommunityResolve";
import {ContentRoute} from "../../module/public/route/sources/ContentRoute/route/ContentRoute/index";
import {ThemesRoute} from "../../module/public/route/sources/ContentRoute/route/ThemesRoute/index";

const appRoutes: Routes = [
    {
        path: '',
        redirectTo: '/p/home/themes',
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
                path: 'home',
                component: ContentGatewayRoute,
                children: [
                    {
                        path: '',
                        redirectTo: 'themes',
                        pathMatch: 'full'
                    },
                    {
                        path: 'themes',
                        component: ThemesRoute,
                    },
                    {
                        path: 'themes/:theme_lvl1',
                        component: ThemesRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'themes/:theme_lvl1/:theme_lvl2',
                        component: ThemesRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3',
                        component: ThemesRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl4',
                        component: ThemesRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5',
                        component: ThemesRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6',
                        component: ThemesRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7',
                        component: ThemesRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8',
                        component: ThemesRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8/:theme_lvl9',
                        component: ThemesRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'content/:type',
                        component: ContentRoute,
                    },
                    {
                        path: 'content/:type/:theme_lvl1',
                        component: ContentRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'content/:type/:theme_lvl1/:theme_lvl2',
                        component: ContentRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'content/:type/:theme_lvl1/:theme_lvl2/:theme_lvl3',
                        component: ContentRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'content/:type/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl4',
                        component: ContentRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'content/:type/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5',
                        component: ContentRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'content/:type/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6',
                        component: ContentRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'content/:type/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7',
                        component: ContentRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'content/:type/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8',
                        component: ContentRoute,
                        pathMatch: 'full'
                    },
                    {
                        path: 'content/:type/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8/:theme_lvl9',
                        component: ContentRoute,
                        pathMatch: 'full'
                    },
                ]
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