import {Component, Input} from "angular2/core";

import {ProfileImage} from "../ProfileImage/index";
import {ProfileExtendedEntity} from "../../../definitions/entity/Profile";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {ThemeService} from "../../../../theme/service/ThemeService";

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
    @Input('profile') entity: ProfileExtendedEntity;

    constructor(private themes: ThemeService) {}

    getGreetings(): string {
        return this.entity.profile.greetings.greetings;
    }

    getProfileURL(): string {
        return queryImage(QueryTarget.Card, this.entity.profile.image).public_path;
    }

    getBanner(): string {
        return this.entity.profile.expert_in_ids.map((id: number) => {
            return this.themes.findById(id);
        }).join(', ');
    }
}