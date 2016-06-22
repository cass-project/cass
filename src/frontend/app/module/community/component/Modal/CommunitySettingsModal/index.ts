import {Component, EventEmitter, Output} from "angular2/core";

import {ModalBoxComponent} from "../../../../modal/component/box";
import {ModalComponent} from "../../../../modal/component";
import {ScreenControls} from "../../../../util/classes/ScreenControls";

import {CommunityService} from "../../../service/CommunityService";
import {CommunityFeaturesService} from "../../../service/CommunityFeaturesService";

import {FeaturesTab} from "./Tab/TabFeatures";
import {GeneralTab} from "./Tab/TabGeneral";
import {ImageTab} from "./Tab/TabImage";
import {CommunitySettingsModalModel} from "./model";
import {CommunityRESTService} from "../../../service/CommunityRESTService";
import {EditCommunityRequest} from "../../../definitions/paths/edit";
import {CommunityControlFeatureRequestModel} from "../../../model/CommunityActivateFeatureModel";



@Component({
    selector: 'cass-community-settings-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
        GeneralTab,
        ImageTab,
        FeaturesTab
    ],
    providers: [
        CommunityFeaturesService
    ]
})

export class CommunitySettingsModal
{
    public screens: ScreenControls<SettingsStage> = new ScreenControls<SettingsStage>(SettingsStage.Image);
    public modelUnmodified:CommunitySettingsModalModel;

    @Output('close') closeEvent = new EventEmitter<CommunitySettingsModal>();

    private loading = false;

    constructor(
        public model:CommunitySettingsModalModel,
        private service: CommunityService,
        private restService: CommunityRESTService,
        private featuresService: CommunityFeaturesService
    ) {
        service.getBySid(model.sid).subscribe(data => {
            model.id = data.entity.id;
            model.title = data.entity.title;
            model.description = data.entity.description;
            model.theme_id = data.entity.theme.id;
            model.public_options = {
                moderation_contract: data.entity.public_options.moderation_contract,
                public_enabled: data.entity.public_options.public_enabled
            };
            model.image = data.entity.image;
            
            this.model.features = [];
            for(let feature of featuresService.getFeatures()) {
                this.model.features.push({
                    "code": feature.code,
                    "is_activated": false,
                    "disabled": featuresService.isDisabled(feature.code)
                });
            }

            this.modelUnmodified = JSON.parse(JSON.stringify(model));
        });
    }

    reset() {
        for(let property in this.model){
            if(this.model.hasOwnProperty(property)){
                if(this.modelUnmodified.hasOwnProperty(property))
                    this.model[property] =  this.modelUnmodified[property];
                else delete this.model[property];
            }
        }
    }

    close() {
        this.closeEvent.emit(this);
    }

    canSave() {
        return JSON.stringify( this.modelUnmodified ) !== JSON.stringify(this.model) && this.loading===false
    }

    saveAllChanges() {
        this.loading = true;
        let requests:Promise<any>[] = [];

        if (
            this.model.title!==this.modelUnmodified.title ||
            this.model.description!==this.modelUnmodified.description ||
            this.model.theme_id!==this.modelUnmodified.theme_id
        ) {
            requests.push(this.restService.edit(this.model.id, <EditCommunityRequest> {
                title: this.model.title,
                description: this.model.description,
                theme_id: this.model.theme_id
            }).toPromise());
        }

        if(this.getModifiedFeatures().length > 0) {
            for (let feature of this.getModifiedFeatures()) {
                let communityFeatureRequest = <CommunityControlFeatureRequestModel> {
                    communityId: this.model.id,
                    feature: feature.code
                };
                if (feature.is_activated) {
                    console.log(communityFeatureRequest);
                    requests.push(this.restService.activateFeature(communityFeatureRequest).toPromise());
                } else {
                    requests.push(this.restService.deactivateFeature(communityFeatureRequest).toPromise());;
                }
            }
        }

        Promise.all(requests).then(responses => {
            this.loading = false;
            this.modelUnmodified = JSON.parse(JSON.stringify(this.model));
            alert("zaebis");
            console.log(responses);
        });

    }

    getModifiedFeatures() {
        return this.model.features.filter((feature) => {
            let featuresUnmodified = this.modelUnmodified.features.filter((unmodifiedFeature) => {
                return unmodifiedFeature.code == feature.code;
            })[0];
            return featuresUnmodified.is_activated != feature.is_activated;
        });
    }
}

enum SettingsStage {
    General = <any>"General",
    Features = <any>"Features",
    Image = <any>"Image"
}
