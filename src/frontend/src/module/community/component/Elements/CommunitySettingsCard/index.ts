import {Component, Directive} from "@angular/core";
import {CommunityModals} from "../../../modals";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-community-settings-card'})
export class CommunitySettingsCard
{
    constructor(private modals: CommunityModals) {}

    openCommunitySettings() {
        this.modals.settings.open();
    }
}