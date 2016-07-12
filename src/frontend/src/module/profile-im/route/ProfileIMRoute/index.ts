import {Component} from "angular2/core";
import {RouterOutlet, RouteConfig} from "angular2/router";

import {ProfileIMMessages} from "../../component/Elements/ProfileIMMessages/index";
import {ProfileIMContacts} from "../../component/Elements/ProfileIMContacts/index";
import {ProfileIMSidebar} from "../../component/Elements/ProfileIMSidebar/index";

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
        component: ProfileIMMessages
    }
])

export class ProfileIMRoute
{
}