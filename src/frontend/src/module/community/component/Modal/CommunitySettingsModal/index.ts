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
import {EditCommunityRequest} from "../../../definitions/paths/edit";
import {CommunityControlFeatureRequestModel} from "../../../model/CommunityActivateFeatureModel";
import {CommunityImageUploadRequestModel} from "../../../model/CommunityImageUploadRequestModel";
import {ImageCropperService} from "../../../../form/component/ImageCropper/index";
import {Observable} from "rxjs/Rx";
import {Response} from "angular2/http";
import {CommunityFeaturesModel} from "../CommunityCreateModal/model";
import {SetPublicOptionsCommunityRequest} from "../../../definitions/paths/set-public-options";


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
        CommunityFeaturesService,
        ImageCropperService
    ]
})

export class CommunitySettingsModal
{
    public screens: ScreenControls<SettingsStage> = new ScreenControls<SettingsStage>(SettingsStage.General);

    @Output('close') closeEvent = new EventEmitter<CommunitySettingsModal>();

    private loading = false;

    constructor(
        public model:CommunitySettingsModalModel,
        public modelUnmodified:CommunitySettingsModalModel,
        private service: CommunityService,
        private cropper: ImageCropperService,
        private featuresService: CommunityFeaturesService
    ) {
        model.public_options = {public_enabled: false, moderation_contract:false};

        service.getBySid(model.sid).subscribe(data => {
            model.id = data.entity.community.id;
            model.title = data.entity.community.title;
            model.description = data.entity.community.description;
            model.theme_id = data.entity.community.theme.has? data.entity.community.theme.id : undefined;
            model.public_options = {
                moderation_contract: data.entity.community.public_options.moderation_contract,
                public_enabled: data.entity.community.public_options.public_enabled
            };
            model.image = data.entity.community.image;
            
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
                    this.model[property] = this.modelUnmodified[property];
                else delete this.model[property];
            }
        }
        this.cropper.reset();
    }

    close() {
        this.closeEvent.emit(this);
    }

    canSave() {
        return JSON.stringify( this.modelUnmodified ) !== JSON.stringify(this.model) && this.loading===false
    }

    saveAllChanges() {
        this.loading = true;
        let requests:Promise<Response>[] = [];

        if (this.isGeneralModified()) {
            requests.push(this.attemptSaveGeneral());
        }

        if(this.isPublicOptionsModified()){
            requests.push(this.attemptSavePublicOptions());
        }

        if(this.isFeaturesModified()) {
            for (let feature of this.getModifiedFeatures()) {
                this.attemptSaveFeature(feature);
            }
        }

        Promise.all(requests).then(() => {
            this.loading = false;
            this.modelUnmodified = JSON.parse(JSON.stringify(this.model));

            if(this.isImageModified()) {
                this.attemptSaveImage()
                    .map(response=>response.json())
                    .subscribe(response => {
                        this.model.image = response.image;
                        delete this.model['new_image'];
                        this.cropper.reset();
                        this.modelUnmodified = JSON.parse(JSON.stringify(this.model));
                    });
            }
        });

    }

    attemptSaveGeneral(): Promise<Response> {
        return this.service.edit(this.model.id, <EditCommunityRequest> {
            title: this.model.title,
            description: this.model.description,
            theme_id: this.model.theme_id
        }).toPromise();
    }

    attemptSavePublicOptions(): Promise<Response> {
        return this.service.setPublicOptions(this.model.id, <SetPublicOptionsCommunityRequest> {
            public_enabled: this.model.public_options.public_enabled,
            moderation_contract: this.model.public_options.moderation_contract
        }).toPromise();
    }

    attemptSaveFeature(feature: CommunityFeaturesModel): Promise<Response> {
        let communityFeatureRequest = <CommunityControlFeatureRequestModel> {
            communityId: this.model.id,
            feature: feature.code
        };
        if (feature.is_activated) {
            return this.service.activateFeature(communityFeatureRequest).toPromise();
        } else {
            return this.service.deactivateFeature(communityFeatureRequest).toPromise();
        }
    }

    attemptSaveImage(): Observable<Response> {
        return this.service.imageUpload(<CommunityImageUploadRequestModel>{
            communityId: this.model.id,
            uploadImage: this.model.new_image.uploadImage,
            x1: this.model.new_image.uploadImageCrop.x,
            y1: this.model.new_image.uploadImageCrop.y,
            x2: this.model.new_image.uploadImageCrop.width + this.model.new_image.uploadImageCrop.x,
            y2: this.model.new_image.uploadImageCrop.height + this.model.new_image.uploadImageCrop.y
        })
    }

    isImageModified(): boolean {
        return !!this.model.new_image
    }

    isFeaturesModified(): boolean {
        return this.getModifiedFeatures().length > 0;
    }

    isGeneralModified(): boolean {
        return this.model.title !== this.modelUnmodified.title ||
            this.model.description !== this.modelUnmodified.description ||
            this.model.theme_id !== this.modelUnmodified.theme_id;
    }

    isPublicOptionsModified(): boolean {
        return this.model.public_options.public_enabled !== this.modelUnmodified.public_options.public_enabled ||
               this.model.public_options.moderation_contract !== this.modelUnmodified.public_options.moderation_contract;
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
