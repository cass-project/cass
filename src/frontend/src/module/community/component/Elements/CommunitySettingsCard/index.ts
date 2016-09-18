import {Component} from "@angular/core";

import {CommunityModals} from "../Community/modals";

@Component({
    selector: 'cass-community-settings-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunitySettingsCard
{
    constructor(private modals: CommunityModals) {}

    openCommunitySettings() {
        this.modals.settings.open();
    }
}