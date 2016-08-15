import {Component, Output, EventEmitter} from "@angular/core";
import {Observable} from "rxjs/Rx";

import {ScreenControls} from "../../../../common/classes/ScreenControls";
import {ModalComponent} from "../../../../modal/component/index";
import {ModalBoxComponent} from "../../../../modal/component/box/index";
import {ImageCropperService} from "../../../../form/component/ImageCropper/index";
import {CommunityFeaturesService} from "../../../../community-features/service/CommunityFeaturesService";
import {CommunityService} from "../../../service/CommunityService";
import {CommunitySettingsModalModel} from "./model";
import {EditCommunityResponse200} from "../../../definitions/paths/edit";
import {SetPublicOptionsCommunityResponse200} from "../../../definitions/paths/set-public-options";
import {CommunityActivateFeatureResponse200} from "../../../../community-features/definitions/paths/activate";
import {UploadCommunityImageResponse200} from "../../../definitions/paths/image-upload";
import {CommunityFeatureEntity} from "../../../../community-features/definitions/entity/CommunityFeature";
import {LoadingManager} from "../../../../common/classes/LoadingStatus";
import {FeaturesTab} from "./Tab/TabFeatures/index";
import {ImageTab} from "./Tab/TabImage/index";
import {GeneralTab} from "./Tab/TabGeneral/index";

enum SettingsStage {
    General = <any>"General",
    Features = <any>"Features",
    Image = <any>"Image"
}

@Component({
    selector: 'cass-community-settings-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        CommunitySettingsModalModel,
        ImageCropperService
    ],
    directives: [
        GeneralTab,
        ImageTab,
        FeaturesTab,
        ModalComponent,
        ModalBoxComponent
    ]
})

export class CommunitySettingsModal
{
    public screens: ScreenControls<SettingsStage> = new ScreenControls<SettingsStage>(SettingsStage.General);
    public modelUnmodified: CommunitySettingsModalModel;
    private loading: LoadingManager = new LoadingManager();
    @Output('close') closeEvent = new EventEmitter<CommunitySettingsModal>();
    
    constructor(
        private model: CommunitySettingsModalModel,
        private communityService: CommunityService,
        private cropper: ImageCropperService,
        private featuresService: CommunityFeaturesService
    ) {
        communityService.communityObservable.subscribe(data=>{
            model.id = data.entity.community.id;
            model.title = data.entity.community.title;
            model.description = data.entity.community.description;
            model.theme_id = data.entity.community.theme.id;
            model.public_options = {
                moderation_contract: data.entity.community.public_options.moderation_contract,
                public_enabled: data.entity.community.public_options.public_enabled
            };
            model.image = data.entity.community.image;
            this.model.features = [];
            
            for(let feature of featuresService.getFeatures()) {
                this.model.features.push({
                    "code": feature.code,
                    "is_activated": data.entity.community.features.filter(featureCode => featureCode === feature.code).length > 0,
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
        return JSON.stringify( this.modelUnmodified ) !== JSON.stringify(this.model)&& !this.loading.isLoading()
    }

    saveAllChanges() {
        let saveLoadingStatus = this.loading.addLoading();
        let requests:Observable<any>[] = [];

        if (this.isGeneralModified()) {
            requests.push(this.attemptSaveGeneral());
        }

        if(this.isPublicOptionsModified()){
            requests.push(this.attemptSavePublicOptions());
        }

        if(this.isFeaturesModified()) {
            for (let feature of this.getModifiedFeatures()) {
                requests.push(this.attemptSaveFeature(feature));
            }
        }

        if(this.isImageModified()) {
            requests.push(this.attemptSaveImage());
        }

        Observable.forkJoin(requests).subscribe(
            responses => {
                for(let response of responses) {
                    if(response.hasOwnProperty('image')) {
                        this.model.image = response.image;
                        delete this.model['new_image'];
                        this.cropper.reset();
                    }
                }
                
                saveLoadingStatus.is = false;
                this.modelUnmodified = JSON.parse(JSON.stringify(this.model));
                
                this.communityService.community.community.title = this.model.title;
                this.communityService.community.community.description = this.model.description;
                this.communityService.community.community.public_options = JSON.parse(JSON.stringify(this.model.public_options));
                this.communityService.community.community.features = this.model.features.map(feature => feature.code);
                this.communityService.community.community.image = JSON.parse(JSON.stringify(this.model.image));
            },
            error => {
                console.log(error);
            }
        );
    }

    attemptSaveGeneral(): Observable<EditCommunityResponse200> {
        return this.communityService.edit(this.model.id, this.model.editCommunityRequest());
    }

    attemptSavePublicOptions(): Observable<SetPublicOptionsCommunityResponse200> {
        return this.communityService.setPublicOptions(this.model.id, this.model.setPublicOptionsCommunityRequest());
    }

    attemptSaveFeature(feature: CommunityFeatureEntity): Observable<CommunityActivateFeatureResponse200> {
        if (feature.is_activated) {
            return this.communityService.activateFeature(this.model.communityActivateFeatureRequest(feature));
        } else {
            return this.communityService.deactivateFeature(this.model.communityActivateFeatureRequest(feature));
        }
    }

    attemptSaveImage(): Observable<UploadCommunityImageResponse200> {
        return this.communityService.imageUpload(
            this.model.id,
            this.model.new_image.uploadImage,
            this.model.new_image.uploadImageCrop.x,
            this.model.new_image.uploadImageCrop.y,
            this.model.new_image.uploadImageCrop.width + this.model.new_image.uploadImageCrop.x,
            this.model.new_image.uploadImageCrop.height + this.model.new_image.uploadImageCrop.y
        );
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

    getModifiedFeatures() : CommunityFeatureEntity[] {
        return this.model.features.filter((feature) => {
            let featuresUnmodified = this.modelUnmodified.features.filter((unmodifiedFeature) => {
                return unmodifiedFeature.code == feature.code;
            })[0];
            return featuresUnmodified.is_activated != feature.is_activated;
        });
    }
    
}