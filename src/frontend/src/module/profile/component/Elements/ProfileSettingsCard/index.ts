import {Component, Directive} from "@angular/core";
import {ProfileModals} from "../../../modals";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-profile-settings-card'})

export class ProfileSettingsCard
{
    constructor(private modals: ProfileModals) {}

    openProfileSettings() {
        this.modals.settings.open();
    }
}