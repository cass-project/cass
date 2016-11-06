import {CommunitiesRoute} from "./index";
import {CommunityThemesRoute} from "./routes/CommunityThemesRoute/index";
import {CommunityFeedRoute} from "./routes/CommunityFeedRoute/index";

export const PUBLIC_COMMUNITY_ROUTES = {
    path: 'communities',
    component: CommunitiesRoute,
    children: [
        {
            path: '',
            redirectTo: 'themes',
            pathMatch: 'full'
        },
        {
            path: 'themes',
            component: CommunityThemesRoute,
        },
        {
            path: 'themes/:theme_lvl1',
            component: CommunityThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2',
            component: CommunityThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3',
            component: CommunityThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl4',
            component: CommunityThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5',
            component: CommunityThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6',
            component: CommunityThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7',
            component: CommunityThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8',
            component: CommunityThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8/:theme_lvl9',
            component: CommunityThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities',
            component: CommunityFeedRoute,
        },
        {
            path: 'entities/:theme_lvl1',
            component: CommunityFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities/:theme_lvl1/:theme_lvl2',
            component: CommunityFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities/:theme_lvl1/:theme_lvl2/:theme_lvl3',
            component: CommunityFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl4',
            component: CommunityFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5',
            component: CommunityFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6',
            component: CommunityFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7',
            component: CommunityFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8',
            component: CommunityFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8/:theme_lvl9',
            component: CommunityFeedRoute,
            pathMatch: 'full'
        },
    ]
};