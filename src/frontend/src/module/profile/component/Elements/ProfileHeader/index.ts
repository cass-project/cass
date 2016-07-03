import {Component, Input} from "angular2/core";

import {ProfileExtendedEntity} from "../../../definitions/entity/Profile";

@Component({
    selector: 'cass-profile-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        
    ]
})
export class ProfileHeader
{
    @Input('profile') entity: ProfileExtendedEntity;

}