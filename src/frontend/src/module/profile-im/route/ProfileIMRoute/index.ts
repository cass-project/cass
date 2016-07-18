import {Component} from "angular2/core";
import {RouterOutlet, RouteConfig} from "angular2/router";

import {ProfileIMChat} from "../../component/Elements/ProfileIMChat";
import {ProfileIMContacts} from "../../component/Elements/ProfileIMContacts";
import {ProfileIMSidebar} from "../../component/Elements/ProfileIMSidebar";

@Component({
    selector:'profile-im-route',
    template: require('./template.jade'),
    styles: [
    require('./style.shadow.scss')
    ],
    directives: [
        RouterOutlet,
        ProfileIMSidebar
    ]
})

@RouteConfig([
    {
        name: 'Contacts',
        path: '/contacts',
        component: ProfileIMContacts,
        useAsDefault: true
    },
    {
        name: 'Messages',
        path: '/messages/:id',
        component: ProfileIMChat
    }
])

export class ProfileIMRoute
{
}