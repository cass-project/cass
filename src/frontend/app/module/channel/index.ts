import {Component} from 'angular2/core';
import {ROUTER_DIRECTIVES, Router, RouteConfig} from 'angular2/router';
import {COMMON_DIRECTIVES} from 'angular2/common';
import {Location} from "angular2/router";
import {CanActivate} from "angular2/router";

import {ChannelRESTService} from './service/ChannelRESTService';
import {ThemeRESTService} from '../theme/service/ThemeRESTService';
import {AddChannelFormComponent} from './form/AddChannelForm/index';

@Component({
    template: require('./template.html'),
    directives: [
        COMMON_DIRECTIVES,
        ROUTER_DIRECTIVES,
        AddChannelFormComponent
    ],
    providers: [ChannelRESTService, ThemeRESTService]
})

@RouteConfig([
    {
        path: '/',
        component: () => { @Component({}) class host{}},
        useAsDefault: true
    },
    {
        path: '/add',
        name: 'AddChannel',
        component: AddChannelFormComponent
    }
])

export class ChannelComponent
{
    constructor(
        private router: Router,
        private location: Location
    ){}

    public isAddChannelRouteActive() : boolean{
        return this.location.path()=="/channels/add";
    }
}