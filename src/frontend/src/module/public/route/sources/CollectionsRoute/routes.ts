import {CollectionsRoute} from "./index";
import {CollectionThemesRoute} from "./routes/CollectionThemesRoute/index";
import {CollectionFeedRoute} from "./routes/CollectionFeedRoute/index";

export const PUBLIC_COLLECTION_ROUTES = {
    path: 'collections',
    component: CollectionsRoute,
    children: [
        {
            path: '',
            redirectTo: 'themes',
            pathMatch: 'full'
        },
        {
            path: 'themes',
            component: CollectionThemesRoute,
        },
        {
            path: 'themes/:theme_lvl1',
            component: CollectionThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2',
            component: CollectionThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3',
            component: CollectionThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl4',
            component: CollectionThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5',
            component: CollectionThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6',
            component: CollectionThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7',
            component: CollectionThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8',
            component: CollectionThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'themes/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8/:theme_lvl9',
            component: CollectionThemesRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities',
            component: CollectionFeedRoute,
        },
        {
            path: 'entities/:theme_lvl1',
            component: CollectionFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities/:theme_lvl1/:theme_lvl2',
            component: CollectionFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities/:theme_lvl1/:theme_lvl2/:theme_lvl3',
            component: CollectionFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl4',
            component: CollectionFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5',
            component: CollectionFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6',
            component: CollectionFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7',
            component: CollectionFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8',
            component: CollectionFeedRoute,
            pathMatch: 'full'
        },
        {
            path: 'entities/:theme_lvl1/:theme_lvl2/:theme_lvl3/:theme_lvl5/:theme_lvl6/:theme_lvl7/:theme_lvl8/:theme_lvl9',
            component: CollectionFeedRoute,
            pathMatch: 'full'
        },
    ]
};