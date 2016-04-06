import {Component} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {AuthService} from '../auth/service/AuthService';
import {ProfileChannelComponent} from './component/ProfileChannelComponent/index';
import {ProfilePersonalDataComponent} from './component/ProfilePersonalDataComponent/index';
import {ThemeCleaner} from "../host-admin/component/ThemeCleaner/component";
import {ProfileEdit} from "./component/ProfileEdit/index";

@Component({
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES
    ],
    styles: [
        require('./style.shadow.scss')
    ]
})
@RouteConfig([
    {
        useAsDefault: true,
        path: '/',
        name: 'Theme-Cleaner',
        component: ThemeCleaner
    },
    {
        path: '/personal',
        name: 'ProfilePersonalData',
        component: ProfilePersonalDataComponent
    },
    {
        path: '/channel/:channelId',
        name: 'ProfileChannel',
        component: ProfileChannelComponent
    },
    {
        path: '/edit',
        name: 'ProfileEdit',
        component: ProfileEdit
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