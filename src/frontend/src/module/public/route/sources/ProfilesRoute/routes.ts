import {ProfilesRoute} from "./index";
import {ProfilesThemesRoute} from "./route/ProfilesThemesRoute/index";
import {ProfilesFeedRoute} from "./route/ProfilesFeedRoute/index";

export const PUBLIC_PROFILES_ROUTES = {
    path: 'people',
    component: ProfilesRoute,
    children: [
        {
            path: '',
            redirectTo: 'themes',
            pathMatch: 'full'
        },
        {
            path: 'themes',
            component: ProfilesThemesRoute,
        },
        {
            path: 'themes/:theme_lvl1',
            component: ProfilesThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2',
            component: ProfilesThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3',
            component: ProfilesThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl4',
            component: ProfilesThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5',
            component: ProfilesThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6',
            component: ProfilesThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7',
            component: ProfilesThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8',
            component: ProfilesThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8/:theme_lvl9',
            component: ProfilesThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 's/:source',
            component: ProfilesFeedRoute,
        },
        {
            path: 's/:source/:theme_lvl1',
            component: ProfilesFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 's/:source/:theme_lvl1/:theme_lvl2',
            component: ProfilesFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 's/:source/:theme_lvl1/:theme_lvl2/:theme_lvl3',
            component: ProfilesFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 's/:source/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl4',
            component: ProfilesFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 's/:source/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5',
            component: ProfilesFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 's/:source/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6',
            component: ProfilesFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 's/:source/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7',
            component: ProfilesFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 's/:source/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8',
            component: ProfilesFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 's/:source/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8/:theme_lvl9',
            component: ProfilesFeedRoute,
            pathMatch: 'full'
        },
    ]
};