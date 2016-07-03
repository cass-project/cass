import {Component} from "angular2/core";
import {ProfileModals} from "../../../modals";

@Component({
    selector: 'cass-profile-interests-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileInterestsCard
{
    constructor(private modals: ProfileModals) {}

    opeInterestsModal() {
        this.modals.interests.open();
    }
}