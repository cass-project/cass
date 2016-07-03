import {Component, Input} from "angular2/core";

import {ProfileExtendedEntity} from "../../../definitions/entity/Profile";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {ProfileImage} from "../ProfileImage/index";
import {TranslateService} from "../../../../translate/service";

@Component({
    selector: 'cass-profile-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileImage,
    ]
})
export class ProfileHeader
{
    @Input('profile') entity: ProfileExtendedEntity;
    
    constructor(private translate: TranslateService) {}

    getProfileGreetings(): string {
        return this.entity.profile.greetings.greetings;
    }

    getProfileURL(): string {
        return queryImage(QueryTarget.Avatar, this.entity.profile.image).public_path;
    }
}