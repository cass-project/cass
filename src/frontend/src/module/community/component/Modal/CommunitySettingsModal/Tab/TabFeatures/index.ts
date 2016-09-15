import {Component} from "@angular/core";
import {CommunityFeaturesService} from "../../../../../service/CommunityFeaturesService";
import {CommunitySettingsModalModel} from "../../model";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-community-settings-modal-tab-features'})

export class FeaturesTab {

    constructor(public model: CommunitySettingsModalModel, private featuresService: CommunityFeaturesService) {
    }
}