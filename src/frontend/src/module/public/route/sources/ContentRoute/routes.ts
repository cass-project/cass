import {ContentGatewayRoute} from "./index";
import {ThemesRoute} from "./route/ThemesRoute/index";
import {ContentRoute} from "./route/ContentRoute/index";

export const PUBLIC_CONTENT_ROUTES = {
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
};