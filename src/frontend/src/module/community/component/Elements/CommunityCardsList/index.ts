import {Component, Input} from "angular2/core";

import {CommunityCard} from "../CommunityCard/index";
import {CommunityInterestsCard} from "../CommunityInterestsCard/index";
import {CommunityCreateCollectionCard} from "../CommunityCreateCollectionCard/index";
import {ProfileSettingsCard} from "../CommunitySettingsCard/index";

import {Router} from "angular2/router";

@Component({
    selector: 'cass-profile-cards-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        CommunityCard,
        CommunityInterestsCard,
        CommunityCreateCollectionCard,
        ProfileSettingsCard,
    ]
})
export class CommunityCardsList
{
    @Input('community') entity: CommunityExtendedEntity;

    constructor(private router: Router) {}

    isOwnProfile(): boolean {
        return this.entity.is_own;
    }

    goDashboard() {
        if(this.isOwnProfile()){
            this.router.navigate(['/Community', 'Profile', { id: 'current' }, 'Dashboard']);
        } else {
            this.router.navigate(['/Profile', 'Profile', {id: this.entity.profile.id.toString()}, 'Dashboard']);
        }
    }
}