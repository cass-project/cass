import {Component, Input} from "angular2/core";
import {ProfileImage} from "../ProfileImage/index";
import {ProfileExtendedEntity} from "../../../definitions/entity/Profile";

@Component({
    selector: 'cass-profile-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileImage
    ]
})
export class ProfileHeader
{
    @Input('profile') profile: ProfileExtendedEntity;
}