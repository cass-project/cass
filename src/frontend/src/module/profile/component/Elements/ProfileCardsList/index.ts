import {Component, Input} from "@angular/core";

import {ProfileCard} from "../ProfileCard/index";
import {ProfileInterestsCard} from "../ProfileInterestsCard/index";
import {ProfileCreateCollectionCard} from "../ProfileCreateCollectionCard/index";
import {ProfileSettingsCard} from "../ProfileSettingsCard/index";
import {ProfileExtendedEntity} from "../../../definitions/entity/Profile";
import {Router} from '@angular/router';

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

    constructor(private router: Router) {}

    isOwnProfile(): boolean {
        return this.entity.is_own;
    }

    goDashboard() {
        if(this.isOwnProfile()){
            this.router.navigate(['/Profile', 'Profile', { id: 'current' }, 'Dashboard']);
        } else {
            this.router.navigate(['/Profile', 'Profile', {id: this.entity.profile.id.toString()}, 'Dashboard']);
        }
    }
}