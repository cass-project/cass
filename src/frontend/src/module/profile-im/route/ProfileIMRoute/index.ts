import {Component, ModuleWithProviders} from "@angular/core";
import {Routes, RouterModule, RouterOutlet} from '@angular/router';

import {ProfileIMChat} from "../../component/Elements/ProfileIMChat";
import {ProfileIMContacts} from "../../component/Elements/ProfileIMContacts";
import {ProfileIMSidebar} from "../../component/Elements/ProfileIMSidebar";

const profileIMRoutes: Routes = [
    {
        path: '/contacts',
        component: ProfileIMContacts,
    },
    {
        path: '/messages/:id',
        component: ProfileIMChat
    }
];

export const profileIMRouting: ModuleWithProviders = RouterModule.forChild(profileIMRoutes);

@Component({
    selector:'profile-im-route',
    template: require('./template.jade'),
    styles: [
    require('./style.shadow.scss')
    ]
})

export class ProfileIMRoute
{
}