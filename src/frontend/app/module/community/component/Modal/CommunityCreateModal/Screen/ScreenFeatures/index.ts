import {Component} from "angular2/core";

import {CommunityCreateModalModel} from "../../model";
import {FrontlineService} from "../../../../../../frontline/service";
import {CommunityFeaturesService} from "../../../../../service/CommunityFeaturesService";
import {Screen} from "../../screen";
import {CommunityCreateModalForm} from "../../Form/index";

@Component({
    selector: 'cass-community-create-modal-screen-features',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [CommunityFeaturesService],
    directives: [CommunityCreateModalForm]
})
export class ScreenFeatures extends Screen
{
    public features = [];

    constructor(public model: CommunityCreateModalModel, private featuresService: CommunityFeaturesService) {
        super();
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