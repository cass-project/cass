import {Component, Input} from "@angular/core";
import {ProfileExtendedEntity} from "../../../definitions/entity/Profile";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-profile-menu'})

export class ProfileMenuComponent
{
    @Input('profile') profile: ProfileExtendedEntity;
}