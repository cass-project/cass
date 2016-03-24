import {Component} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';

import {ProfileChannelComponent} from './component/ProfileChannelComponent/index';
import {ProfilePersonalDataComponent} from './component/ProfilePersonalDataComponent/index';

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
        path: '/personal',
        name: 'ProfilePersonalData',
        component: ProfilePersonalDataComponent,
        useAsDefault: true
    },
    {
        path: '/channel/:channelId',
        name: 'ProfileChannel',
        component: ProfileChannelComponent
    }
])
export class ProfileComponent
{
}