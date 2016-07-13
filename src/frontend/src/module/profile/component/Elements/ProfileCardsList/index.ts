import {Component, Input} from "angular2/core";

import {ProfileCard} from "../ProfileCard/index";
import {ProfileInterestsCard} from "../ProfileInterestsCard/index";
import {ProfileCreateCollectionCard} from "../ProfileCreateCollectionCard/index";
import {ProfileSettingsCard} from "../ProfileSettingsCard/index";
import {ProfileExtendedEntity} from "../../../definitions/entity/Profile";

@Component({
    selector: 'cass-profile-cards-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileCard,
        ProfileInterestsCard,
        ProfileCreateCollectionCard,
        ProfileSettingsCard,
    ]
})
export class ProfileCardsList
{
    @Input('profile') entity: ProfileExtendedEntity;

    isOwnProfile(): boolean {
        return this.entity.is_own;
    }

}