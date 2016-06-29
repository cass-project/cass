import {Component} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
import {RouteConfig, ROUTER_DIRECTIVES} from "angular2/router";

import {AuthComponentService} from "./module/auth/component/Auth/service";
import {CommunityModalService} from "./module/community/service/CommunityModalService";
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
import {ModalService} from "./module/modal/component/service";
import {CommunityRoute} from "./module/community/route/CommunityRoute/index";
import {MessageBusService} from "./module/message/service/MessageBusService/index";
import {MessageBusNotifications} from "./module/message/component/MessageBusNotifications/index";
import {HtmlComponent} from "./module/html/index";
import {CommunityService} from "./module/community/service/CommunityService";
import {CollectionRESTService} from "./module/collection/service/CollectionRESTService";
import {ProfileRESTService} from "./module/profile/service/ProfileRESTService";
import {CommunitySettingsModalModel} from "./module/community/component/Modal/CommunitySettingsModal/model";
import {AuthRESTService} from "./module/auth/service/AuthRESTService";
import {CurrentAccountService} from "./module/auth/service/CurrentAccountService";
import {FeedbackRoute} from "./module/feedback/route/FeedbackRoute/index";
import {FeedbackCreateButton} from "./module/feedback/component/Elements/FeedbackCreateButton/index";

@Component({
    selector: 'cass-bootstrap',
    template: require('./template.html'),
    providers: [
        ModalService,
        MessageBusService,
        AuthService,
        AuthRESTService,
        AuthComponentService,
        CurrentAccountService,
        CommunityModalService,
        CommunityRESTService,
        CommunityService,
        ThemeService,
        ProfileSwitcherService,
        ProfileRESTService,
        CollectionRESTService,
        CommunitySettingsModalModel
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
        FeedbackCreateButton,
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
        name: 'Html',
        path: '/html/...',
        component: HtmlComponent,
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
    },
    {
        name: 'Feedback',
        path: '/feedback/...',
        component: FeedbackRoute
    }
])
export class App {
    constructor(private authService: AuthService) {
        // Do not(!) remove authService dependency.
    }

    static version(): string {
        return require('./../package.json').version;
    }
}

console.log(`CASS Frontend App: ver${App.version()}`);