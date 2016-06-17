import {Component} from "angular2/core";

import {CommunityFeaturesService} from "../../../../../service/CommunityFeaturesService";
import {CommunityFeaturesModel} from "../../../CommunityCreateModal/model";
import {CommunityEnity} from "../../../../../enity/Community";

@Component({
    selector: 'cass-community-settings-modal-tab-features',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class FeaturesTab {

    private features:CommunityFeaturesModel[] = [];

    constructor(public model: CommunityEnity, private featuresService: CommunityFeaturesService) {

        for(let feature of featuresService.getFeatures()) {
            this.features.push({
                "code" : feature.code,
                "is_activated" : false,
                "disabled": featuresService.isDisabled(feature.code)
            });
        }
    }
}