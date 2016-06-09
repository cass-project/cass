import {Component} from "angular2/core";
import {CommunityCreateModalModel} from "../../../CommunityCreateModal/model";
import {CommunityFeaturesService} from "../../../../../service/CommunityFeaturesService";

@Component({
    selector: 'cass-community-settings-modal-tab-features',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class FeaturesTab {

    constructor(public model: CommunityCreateModalModel, private featuresService: CommunityFeaturesService) {
        if(!this.model.features.length) {
            for(let feature of featuresService.getFeatures()) {
                this.model.features.push({
                    "code": feature.code,
                    "is_activated": false,
                    "disabled": featuresService.isDisabled(feature.code)
                });
            }
        }
    }

}