import {Component} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {AuthService} from '../auth/service/AuthService';
import {ProfileEditComponent} from "./component/ProfileEdit/index";
import {ProfileDashboardComponent} from "./component/ProfileDashboard/index";

@Component({
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES
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
    }
])
export class ProfileComponent
{
    constructor(private router: Router, private auth: AuthService) {
        if(!this.auth.signedIn) {
            router.navigate(['Auth']);
        }
    }
}