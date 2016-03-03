import {Component} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {COMMON_DIRECTIVES} from 'angular2/common';

import {ChannelRESTService} from './service/ChannelRESTService';
import {ChannelEditorService} from './service/ChannelEditorService';
import {ChannelListComponent} from './component/ChannelListComponent/index';
import {CreateChannelFormComponent} from './component/CreateChannelFormComponent/index';

@Component({
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES,
        COMMON_DIRECTIVES
    ],
    providers:[ChannelRESTService, ChannelEditorService]
})

@RouteConfig([
    {
        path: '/',
        name: 'ChannelList',
        component: ChannelListComponent,
        useAsDefault: true
    },
    {
        path: '/create',
        name: 'CreateChannel',
        component: CreateChannelFormComponent
    }
])

export class ChannelComponent {
}