import {Component, Input} from "@angular/core";

import {ProfileComponent} from "../../../index";
import {ProfileExtendedEntity} from "../../../definitions/entity/Profile";

@Component({
    selector: 'cass-profile-menu',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileMenuComponent
{
    @Input('profile') profile: ProfileExtendedEntity;
}