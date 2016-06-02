import {Component} from "angular2/core";

import {Screen} from "../../screen";
import {CommunityCreateModalModel} from "../../model";
import {FrontlineService} from "../../../../../../frontline/service";
import {CommunityFeaturesService} from "../../../../../service/CommunityFeaturesService";

@Component({
    selector: 'cass-community-create-modal-screen-features',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [CommunityFeaturesService]
})
export class ScreenFeatures extends Screen
{
    public features = [];

    constructor(public model: CommunityCreateModalModel, private featuresService: CommunityFeaturesService) {
        super(model);
        this.features = featuresService.getFeatures();
        for(let feature of this.features) {
            this.model.features.push({
                "code" : feature.code,
                "is_activated" : false,
                "disabled": featuresService.isDisabled(feature.code)
            });
        }
    }
}