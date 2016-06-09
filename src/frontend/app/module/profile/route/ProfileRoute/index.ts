import {Component} from "angular2/core";

import {RouterOutlet, RouteConfig, Router} from "angular2/router";
import {ModalComponent} from "../../../modal/component/index";
import {ProfileMenuComponent} from "../../component/ProfileMenu/index";
import {ProfileModal} from "../../component/ProfileModal/index";
import {ProfileDashboardRoute} from "../ProfileDashboardRoute/index";
import {ModalBoxComponent} from "../../../modal/component/box/index";
import {ProfileNotFound} from "../ProfileNotFound/index";
import {ProfileCurrentRoute} from "../ProfileCurrentRoute/index";
import {ProfileCurrentCollectionsRoute} from "../ProfileCurrentCollectionsRoute/index";
import {ProfileIDRoute} from "../ProfileIDRoute/index";
import {ProfileIDCollectionsRoute} from "../ProfileIDCollectionsRoute/index";
import {FrontlineService} from "../../../frontline/service";
import {AuthService} from "../../../auth/service/AuthService";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        RouterOutlet,
        ModalComponent,
        ModalBoxComponent,
        ProfileMenuComponent,
        ProfileModal,
    ]
})
@RouteConfig([
    {
        name: 'Dashboard',
        path: '/',
        component: ProfileDashboardRoute,
        useAsDefault: true
    },
    {
        name: 'ProfileIDRoute',
        path: '/:sid',
        component: ProfileIDRoute,
    },
    {
        name: 'ProfileColletions',
        path: '/:sid/collections',
        component: ProfileIDCollectionsRoute,
    },
    {
        name: 'ProfileColletionsById',
        path: '/:sid/collections/:sid',
        component: ProfileIDCollectionsRoute,
    },
    {
        name: 'ProfileNotFound',
        path: '/not-found',
        component: ProfileNotFound
    },
    {
        name: 'ProfileCurrentRoute',
        path: '/current',
        component: ProfileCurrentRoute
    },
    {
        name: 'ProfileCurrentCollectionsRoute',
        path: '/current/collections',
        component: ProfileCurrentCollectionsRoute
    },
    {
        name: 'ProfileCurrentCollectionsRouteSid',
        path: '/current/collections/:sid',
        component: ProfileCurrentCollectionsRoute
    }
])
export class ProfileRoute
{
}