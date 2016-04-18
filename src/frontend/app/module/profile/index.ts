import {Component} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {AuthService} from '../auth/service/AuthService';
import {ProfileEditComponent} from "./component/ProfileEdit/index";
import {ProfileDashboardComponent} from "./component/ProfileDashboard/index";
import {AccountWelcome} from "./component/AccountWelcome/component";
import {AvatarCropper} from "./component/AvatarCropper/index";
import {ProfileService} from "./service/ProfileService";

@Component({
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES
    ],
    'providers': [
        ProfileService
    ]
})
@RouteConfig([
    {
        useAsDefault: true,
        name: 'Dashboard',
        path: '/',
        component: ProfileDashboardComponent
    },
    {
        name: 'Edit',
        path: '/edit',
        component: ProfileEditComponent
    },
    {
        name: 'Welcome',
        path: '/welcome/...',
        component: AccountWelcome
    },
    {
        name: 'AvatarEdit',
        path: '/edit/avatar',
        component: AvatarCropper
    }
])
export class ProfileComponent
{
    constructor(private router: Router
    ) {
        if(! AuthService.isSignedIn()) {
            router.navigate(['Auth']);
        }
    }
}