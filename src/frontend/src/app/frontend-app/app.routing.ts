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
import {CommunityResolve} from "../../module/community/resolve/CommunityResolve";
import {ProfileSubscriptionsRoute} from "../../module/profile/route/ProfileSubscriptionsRoute/index";
import {ThemesSubscriptionsRoute} from "../../module/profile/route/ProfileSubscriptionsRoute/routes/ThemesSubscriptionsRoute/index";
import {CollectionSubscriptionsRoute} from "../../module/profile/route/ProfileSubscriptionsRoute/routes/CollectionSubscriptionsRoute/index";
import {CommunitiesSubscriptionsRoute} from "../../module/profile/route/ProfileSubscriptionsRoute/routes/CommunitiesSubscriptionsRoute/index";
import {ProfilesSubscriptionsRoute} from "../../module/profile/route/ProfileSubscriptionsRoute/routes/ProfilesSubscriptionsRoute/index";
import {ProfileSubscriptionsDashboardRoute} from "../../module/profile/route/ProfileSubscriptionsRoute/routes/ProfileSubscriptionsDashboardRoute/index";
import {PUBLIC_CONTENT_ROUTES} from "../../module/public/route/sources/ContentRoute/routes";
import {PUBLIC_PROFILES_ROUTES} from "../../module/public/route/sources/ProfilesRoute/routes";
import {PUBLIC_COLLECTION_ROUTES} from "../../module/public/route/sources/CollectionsRoute/routes";
import {PUBLIC_COMMUNITY_ROUTES} from "../../module/public/route/sources/CommunitiesRoute/routes";


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
                        path: 'subscriptions',
                        component: ProfileSubscriptionsRoute,
                        children: [

                            {
                                path: '',
                                component: ProfileSubscriptionsDashboardRoute
                            },

                            {
                                path: 'themes',
                                component: ThemesSubscriptionsRoute,
                            },

                            {
                                path: 'collections',
                                component: CollectionSubscriptionsRoute,
                            },

                            {
                                path: 'communities',
                                component: CommunitiesSubscriptionsRoute,
                            },

                            {
                                path: 'profiles',
                                component: ProfilesSubscriptionsRoute,
                            }
                        ]
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
            PUBLIC_CONTENT_ROUTES,
            PUBLIC_PROFILES_ROUTES,
            PUBLIC_COLLECTION_ROUTES,
            PUBLIC_COMMUNITY_ROUTES,
        ]
    }
];

export const appRoutingProviders: any[] = [];

export const routing: ModuleWithProviders = RouterModule.forRoot(appRoutes);