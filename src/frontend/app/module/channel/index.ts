import {Component} from 'angular2/core';
import {ROUTER_DIRECTIVES, Router, RouteConfig} from 'angular2/router';
import {COMMON_DIRECTIVES} from 'angular2/common';

import {ChannelRESTService} from './service/ChannelRESTService';
import {AddChannelFormComponent} from './form/AddChannelForm/index';

@Component({
    template: require('./template.html'),
    directives: [
        COMMON_DIRECTIVES,
        ROUTER_DIRECTIVES,
        AddChannelFormComponent
    ],
    providers:[ChannelRESTService]
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
        private router: Router
    ){}

    public addChannel(){
        this.router.navigate(['AddChannel'])
    }

    public isAddChannelRouteActive() : boolean{
        let addChannelRoute = this.router.generate(['AddChannel']);
        return this.router.isRouteActive(addChannelRoute);
    }
}