import {ContentRoute} from "./index";
import {ContentThemesRoute} from "./route/ContentThemesRoute/index";
import {ContentFeedRoute} from "./route/ContentFeedRoute/index";

export const PUBLIC_CONTENT_ROUTES = {
    path: 'home',
    component: ContentRoute,
    children: [
        {
            path: '',
            redirectTo: 'themes',
            pathMatch: 'full'
        },
        {
            path: 'themes',
            component: ContentThemesRoute,
        },
        {
            path: 'themes/:theme_lvl1',
            component: ContentThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2',
            component: ContentThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3',
            component: ContentThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl4',
            component: ContentThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5',
            component: ContentThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6',
            component: ContentThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7',
            component: ContentThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8',
            component: ContentThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8/:theme_lvl9',
            component: ContentThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'content/:type',
            component: ContentFeedRoute,
        },
        {
            path: 'content/:type/:theme_lvl1',
            component: ContentFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'content/:type/:theme_lvl1/:theme_lvl2',
            component: ContentFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'content/:type/:theme_lvl1/:theme_lvl2/:theme_lvl3',
            component: ContentFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'content/:type/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl4',
            component: ContentFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'content/:type/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5',
            component: ContentFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'content/:type/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6',
            component: ContentFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'content/:type/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7',
            component: ContentFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'content/:type/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8',
            component: ContentFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'content/:type/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8/:theme_lvl9',
            component: ContentFeedRoute,
            pathMatch: 'full'
        },
    ]
};