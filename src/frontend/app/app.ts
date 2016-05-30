import {Component} from "angular2/core";
import {RouteConfig} from "angular2/router";

import {AuthComponentService} from "./module/auth/component/Auth/service";
import {ProfileComponentService} from "./module/profile/service";
import {CommunityComponentService} from "./module/community/service";
import {CommunityRESTService} from "./module/community/service/CommunityRESTService";
import {ThemeService} from "./module/theme/service/ThemeService";
import {ROUTER_DIRECTIVES} from "angular2/router";
import {CORE_DIRECTIVES} from "angular2/common";
import {AuthComponent} from "./module/auth/component/Auth/index";
import {AccountComponent} from "./module/account/index";
import {ProfileComponent} from "./module/profile/index";
import {SidebarComponent} from "./module/sidebar/index";
import {CommunityComponent} from "./module/community/index";
import {RouterOutlet} from "angular2/router";
import {LandingComponent} from "./module/landing/index";
import {ProfileRoute} from "./module/profile/route/ProfileRoute/index";
import {AuthService} from "./module/auth/service/AuthService";

@Component({
    selector: 'cass-bootstrap',
    template: require('./template.html'),
    providers: [
        AuthService,
        AuthComponentService,
        ProfileComponentService,
        CommunityComponentService,
        CommunityRESTService,
        ThemeService,
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CORE_DIRECTIVES,
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
    }
])
export class App {
    constructor(private authService: AuthService) {
        // Do not(!) remove authService dependency.
    }
}