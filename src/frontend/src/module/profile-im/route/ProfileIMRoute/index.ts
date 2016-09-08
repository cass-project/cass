import {Component, ModuleWithProviders} from "@angular/core";
import {Routes, RouterModule, RouterOutlet} from '@angular/router';

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

const profileIMRoutes: Routes = [
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
];

export const profileIMRouting: ModuleWithProviders = RouterModule.forChild(profileIMRoutes);

export class ProfileIMRoute
{
}