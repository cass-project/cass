import {Component} from "@angular/core";
import {ProfileModals} from "../../../modals";

@Component({
    selector: 'cass-profile-settings-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileSettingsCard
{
    constructor(private modals: ProfileModals) {}

    openProfileSettings() {
        this.modals.settings.open();
    }
}