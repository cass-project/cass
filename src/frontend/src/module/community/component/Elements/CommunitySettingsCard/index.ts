import {Component} from "angular2/core";
import {CommunityModals} from "../../../modals";

@Component({
    selector: 'cass-community-settings-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileSettingsCard
{
    constructor(private modals: CommunityModals) {}

    openProfileSettings() {
        this.modals.settings.open();
    }
}