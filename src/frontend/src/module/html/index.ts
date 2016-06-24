import {Component} from "angular2/core";
import {RouteConfig, ROUTER_DIRECTIVES} from "angular2/router";

import {Nothing} from "../util/component/Nothing/index";
import {CollectionCreateMasterDemo} from "./demo/CollectionCreateMasterDemo/index";
import {ProgressBarDemo} from "./demo/ProgressBarDemo/index";
import {CommunitySettingsModalDemo} from "./demo/CommunitySettingsModalDemo/index";
import {CollectionSettingsDemo} from "./demo/CollectionSettingsDemo/index";

@Component({
    template: require('./template.jade'),
    directives: [
        ROUTER_DIRECTIVES
    ]
})
@RouteConfig([
    {
        name: 'Index',
        path: '/',
        useAsDefault: true,
        component: Nothing
    },
    {
        name: 'CollectionCreateMasterDemo',
        path: '/collection-create-master-demo',
        component: CollectionCreateMasterDemo
    },
    {
        name: 'ProgressBarDemo',
        path: '/progress-bar-demo',
        component: ProgressBarDemo
    },
    {
        name: 'CommunitySettingsModalDemo',
        path: '/community-settings-modal-demo',
        component: CommunitySettingsModalDemo
    },
    {
        name: 'CollectionSettingsDemo',
        path: '/collection-settings-demo',
        component: CollectionSettingsDemo
    }
])
export class HtmlComponent
{
}