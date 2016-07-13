import {Component} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
import {RouteConfig, ROUTER_DIRECTIVES, RouterOutlet} from "angular2/router";

import {CollectionModals} from "../../module/collection/modals";
import {CurrentAccountService} from "../../module/account/service/CurrentAccountService";
import {CurrentProfileService} from "../../module/profile/service/CurrentProfileService";
import {TranslateService} from "../../module/translate/service";
import {ModalService} from "../../module/modal/component/service";
import {MessageBusService} from "../../module/message/service/MessageBusService/index";
import {AuthService} from "../../module/auth/service/AuthService";
import {AuthRESTService} from "../../module/auth/service/AuthRESTService";
import {CommunityModalService} from "../../module/community/service/CommunityModalService";
import {CommunityRESTService} from "../../module/community/service/CommunityRESTService";
import {AuthComponentService} from "../../module/auth/component/Auth/service";
import {CommunityService} from "../../module/community/service/CommunityService";
import {ThemeService} from "../../module/theme/service/ThemeService";
import {ProfileSwitcherService} from "../../module/profile/component/Modals/ProfileSwitcher/service";
import {ProfileRESTService} from "../../module/profile/service/ProfileRESTService";
import {CollectionRESTService} from "../../module/collection/service/CollectionRESTService";
import {CommunitySettingsModalModel} from "../../module/community/component/Modal/CommunitySettingsModal/model";
import {PostRESTService} from "../../module/post/service/PostRESTService";
import {PostAttachmentRESTService} from "../../module/post-attachment/service/PostAttachmentRESTService";
import {ProfileCachedIdentityMap} from "../../module/profile/service/ProfileCachedIdentityMap";
import {ProfileModals} from "../../module/profile/modals";
import {MessageBusNotifications} from "../../module/message/component/MessageBusNotifications/index";
import {AuthComponent} from "../../module/auth/component/Auth/index";
import {AccountComponent} from "../../module/account/index";
import {ProfileComponent} from "../../module/profile/index";
import {SidebarComponent} from "../../module/sidebar/index";
import {CommunityComponent} from "../../module/community/index";
import {FeedbackComponent} from "../../module/feedback/index";
import {HtmlComponent} from "../../module/html/index";
import {RootRoute as ProfileRootRoute} from "../../module/profile/route/RootRoute/index";
import {CommunityRoute} from "../../module/community/route/CommunityRoute/index";
import {PublicService} from "../../module/public/service";
import {PublicComponent} from "../../module/public/index";
import {ProfileModalModel} from "../../module/profile/component/Modals/ProfileModal/model";
import {AccountRESTService} from "../../module/account/service/AccountRESTService";
import {PostTypeService} from "../../module/post/service/PostTypeService";
import {FeedRESTService} from "../../module/feed/service/FeedRESTService";
import {ProfileIMService} from "../../module/profile-im/service/ProfileIMService";
import {ProfileIMRESTService} from "../../module/profile-im/service/ProfileIMRESTService";
import {ProfileIMRoute} from "../../module/profile-im/route/ProfileIMRoute/index";
import {ContactRESTService} from "../../module/contact/service/ContactRESTService";

@Component({
    selector: 'cass-frontend-app',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ModalService,
        CurrentAccountService,
        CurrentProfileService,
        TranslateService,
        MessageBusService,
        AuthService,
        AuthRESTService,
        AuthComponentService,
        AccountRESTService,
        CommunityModalService,
        CommunityRESTService,
        CommunityService,
        ThemeService,
        ProfileSwitcherService,
        ProfileRESTService,
        CollectionRESTService,
        CommunitySettingsModalModel,
        PostRESTService,
        PostAttachmentRESTService,
        ProfileCachedIdentityMap,
        ProfileModals,
        CollectionModals,
        PublicService,
        ProfileModalModel,
        PostTypeService,
        FeedRESTService,
        ProfileIMRESTService,
        ProfileIMService,
        ContactRESTService,
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
        FeedbackComponent,
        RouterOutlet
    ]
})
@RouteConfig([
    {
        name: 'Html',
        path: '/html/...',
        component: HtmlComponent,
    },
    {
        name: 'Profile',
        path: '/profile/...',
        component: ProfileRootRoute
    },
    {
        name: 'ProfileIM',
        path: '/im/...',
        component: ProfileIMRoute
    },
    {
        name: 'Community',
        path: '/community/...',
        component: CommunityRoute
    },
    {
        name: 'Public',
        path: '/public/...',
        component: PublicComponent,
        useAsDefault: true
    }
])
export class App {
    static version(): string {
        return require('./../../../package.json').version;
    }
}

console.log(`CASS Frontend App: ver${App.version()}`);