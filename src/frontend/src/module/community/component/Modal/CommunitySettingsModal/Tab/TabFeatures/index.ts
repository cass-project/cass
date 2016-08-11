import {Component} from "@angular/core";

import {CommunityFeaturesService} from "../../../../../../community-features/service/CommunityFeaturesService";
import {CommunitySettingsModalModel} from "../../model";

@Component({
    selector: 'cass-community-settings-modal-tab-features',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class FeaturesTab {

    constructor(public model: CommunitySettingsModalModel, private featuresService: CommunityFeaturesService) {
    }
}