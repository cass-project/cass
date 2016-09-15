import {Component, Input} from "@angular/core";
import {ProfileExtendedEntity} from "../../../definitions/entity/Profile";
import {Router} from "@angular/router";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-profile-cards-list'})

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