import {Component, ModuleWithProviders} from "@angular/core";
import {Routes, RouterModule} from "@angular/router";
import {ProfileIMChat} from "../../component/Elements/ProfileIMChat";
import {ProfileIMContacts} from "../../component/Elements/ProfileIMContacts";

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
    template: require('./template.jade'),
    styles: [
    require('./style.shadow.scss')
    ],selector: 'profile-im-route'})

export class ProfileIMRoute
{
}