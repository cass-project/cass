import {Component} from "angular2/core";
import {CommunityModals} from "../../../modals";

@Component({
    selector: 'cass-profile-interests-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityInterestsCard
{
    constructor(private modals: CommunityModals) {}

    openInterestsModal() {
        this.modals.interests.open();
    }
}