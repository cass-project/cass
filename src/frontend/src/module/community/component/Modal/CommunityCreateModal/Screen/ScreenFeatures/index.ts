import {Component} from "@angular/core";

import {CommunityCreateModalModel, CommunityFeaturesModel} from "../../model";
import {CommunityFeaturesService} from "../../../../../service/CommunityFeaturesService";
import {Screen} from "../../screen";

@Component({
    template: require('./template.jade'),
    selector: 'cass-community-create-modal-screen-features',
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        CommunityFeaturesService
    ]
})
export class ScreenFeatures extends Screen
{
    private features: CommunityFeaturesModel[] = [];

    constructor(
        public model: CommunityCreateModalModel,
        private featuresService: CommunityFeaturesService
    ) {
        super();

        this.features = featuresService.getFeatures();

        for(let feature of this.features) {
            this.model.features.push({
                code : feature.code,
                is_activated: false,
                disabled: featuresService.isDisabled(feature.code)
            });
        }

        this.model.features.filter(feature => feature.code === 'collections')[0].is_activated = true;
    }
}