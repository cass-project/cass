import {Component} from "@angular/core";

import {CommunityModalService} from "../../../service/CommunityModalService";

@Component({
    selector: 'cass-community-settings-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunitySettingsCard
{
    constructor(private modals: CommunityModalService) {}

    openCommunitySettings() {
        this.modals.settings.open();
    }
}