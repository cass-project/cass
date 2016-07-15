import {Component, Input} from "angular2/core";

import {CommunityComponent} from "../../../index";
import {ProfileExtendedEntity} from "../../../definitions/entity/Profile";

@Component({
    selector: 'cass-profile-menu',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        CommunityComponent
    ]
})
export class ProfileMenuComponent
{
    @Input('community') community: ProfileExtendedEntity;
}