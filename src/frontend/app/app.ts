import {Component} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
import {RouteConfig, ROUTER_DIRECTIVES} from "angular2/router";

import {AuthComponentService} from "./module/auth/component/Auth/service";
import {ProfileComponentService} from "./module/profile/service";
import {CommunityComponentService} from "./module/community/service";
import {CommunityRESTService} from "./module/community/service/CommunityRESTService";
import {ThemeService} from "./module/theme/service/ThemeService";
import {AuthComponent} from "./module/auth/component/Auth/index";
import {AccountComponent} from "./module/account/index";
import {ProfileComponent} from "./module/profile/index";
import {SidebarComponent} from "./module/sidebar/index";
import {CommunityComponent} from "./module/community/index";
import {RouterOutlet} from "angular2/router";
import {LandingComponent} from "./module/landing/index";
import {ProfileRoute} from "./module/profile/route/ProfileRoute/index";
import {AuthService} from "./module/auth/service/AuthService";
import {ProfileSwitcherService} from "./module/profile/component/ProfileSwitcher/service";
import {ProfileRESTService} from "./module/profile/component/ProfileService/ProfileRESTService";
import {ModalService} from "./module/modal/component/service";
import {CommunityRoute} from "./module/community/route/CommunityRoute/index";
import {MessageBusService} from "./module/message/service/MessageBusService/index";
import {MessageBusNotifications} from "./module/message/component/MessageBusNotifications/index";

@Component({
    selector: 'cass-bootstrap',
    template: require('./template.html'),
    providers: [
        ModalService,
        MessageBusService,
        AuthService,
        AuthComponentService,
        ProfileComponentService,
        CommunityComponentService,
        CommunityRESTService,
        ThemeService,
        ProfileSwitcherService,
        ProfileRESTService
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CORE_DIRECTIVES,
        MessageBusNotifications,
        AuthComponent,
        AccountComponent,
        ProfileComponent,
        SidebarComponent,
        CommunityComponent,
        RouterOutlet
    ]
})
@RouteConfig([
    {
        name: 'Landing',
        path: '/',
        component: LandingComponent,
        useAsDefault: true
    },
    {
        name: 'Profile',
        path: '/profile/...',
        component: ProfileRoute
    },
    {
        name: 'Community',
        path: '/community/...',
        component: CommunityRoute
    }
])
export class App {
    constructor(private authService: AuthService) {
        // Do not(!) remove authService dependency.
    }
}