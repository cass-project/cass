import {Component} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {AuthService} from '../auth/service/AuthService';
import {ProfileEditComponent} from "./component/ProfileEdit/index";
import {ProfileDashboardComponent} from "./component/ProfileDashboard/index";
import {AccountWelcome} from "./component/AccountWelcome/component";
import {Modal} from "../common/component/Modal/index";

@Component({
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES
    ],
    'providers': [
        Modal
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
        path: '/welcome',
        component: AccountWelcome
    }
])
export class ProfileComponent
{
    constructor(private router: Router,
                private auth: AuthService,
                private modal: Modal
    ) {
        if(!this.auth.signedIn) {
            router.navigate(['Auth']);
        }
    }
    openFormContentBox() {
        this.modal.showFormContentBox = true;
    }
}