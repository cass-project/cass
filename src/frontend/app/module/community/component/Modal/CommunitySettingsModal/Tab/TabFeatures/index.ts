import {Component} from "angular2/core";

import {CommunityCreateModalModel} from "../../../CommunityCreateModal/model";
import {CommunityFeaturesService} from "../../../../../service/CommunityFeaturesService";
import {CommunityModel} from "../../../../../model";
import {CommunityFeaturesModel} from "../../../CommunityCreateModal/model";

@Component({
    selector: 'cass-community-settings-modal-tab-features',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class FeaturesTab {

    private features:CommunityFeaturesModel[] = [];

    constructor(public model: CommunityModel, private featuresService: CommunityFeaturesService) {

        for(let feature of featuresService.getFeatures()) {
            this.features.push({
                "code" : feature.code,
                "is_activated" : false,
                "disabled": featuresService.isDisabled(feature.code)
            });
        }
    }
}