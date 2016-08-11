import {Component} from "@angular/core";

import {CommunityCreateModalModel} from "../../model";
import {Screen} from "../screen";
import {CommunityFeaturesService} from "../../../../../../community-features/service/CommunityFeaturesService";
import {CommunityCreateModalForm} from "../../Form";

@Component({
    selector: 'cass-community-create-modal-screen-features',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [CommunityCreateModalForm]
})
export class ScreenFeatures extends Screen
{
    constructor(public model: CommunityCreateModalModel, private featuresService: CommunityFeaturesService) {
        super();
        
        for(let feature of featuresService.getFeatures()) {
            this.model.features.push({
                code : feature.code,
                is_activated: false,
                disabled: featuresService.isDisabled(feature.code)
            });
        }

        this.model.features.filter(feature => feature.code === 'collections')[0].is_activated = true;
    }
}