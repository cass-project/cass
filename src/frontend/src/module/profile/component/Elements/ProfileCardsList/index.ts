import {Component, Input} from "@angular/core";

import {ProfileExtendedEntity} from "../../../definitions/entity/Profile";
import {Router} from "@angular/router";

@Component({
    selector: 'cass-profile-cards-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
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
            this.router.navigate(['/profile', 'current']);
        } else {
            this.router.navigate(['/profile', this.entity.profile.id.toString()]);
        }
    }
}