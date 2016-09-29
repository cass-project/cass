import {Component, EventEmitter, Output} from "@angular/core";
import {Observable} from "rxjs/Rx";

import {ScreenControls} from "../../../../common/classes/ScreenControls";
import {CommunityFeaturesService} from "../../../service/CommunityFeaturesService";
import {CommunitySettingsModalModel} from "./model";
import {ImageCropperService} from "../../../../common/component/ImageCropper/index";
import {CommunityFeaturesModel} from "../CommunityCreateModal/model";
import {CommunityRESTService} from "../../../service/CommunityRESTService";

@Component({
    selector: 'cass-community-settings',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        CommunityFeaturesService,
        ImageCropperService
    ]
})
export class CommunitySettingsModal
{
    @Output('close') closeEvent = new EventEmitter<CommunitySettingsModal>();

    public screens: ScreenControls<SettingsStage> = new ScreenControls<SettingsStage>(SettingsStage.General);
    private loading = false;

    constructor(
        public model:CommunitySettingsModalModel,
        public modelUnmodified:CommunitySettingsModalModel,
        private cropper: ImageCropperService,
        private featuresService: CommunityFeaturesService,
        private rest: CommunityRESTService
    ) {
        rest.getCommunityBySid(model.sid).subscribe(data => {
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

        let requests: Observable<any>[] = [];

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

        Observable.forkJoin(requests).subscribe(
            success => {
                this.loading = false;
                this.modelUnmodified = JSON.parse(JSON.stringify(this.model));

                if(this.isImageModified()) {
                    this.attemptSaveImage()
                        .subscribe(response => {
                            this.model.image = response.image;
                            delete this.model['new_image'];
                            this.cropper.reset();
                            this.modelUnmodified = JSON.parse(JSON.stringify(this.model));
                        });
                }
            },
            error => {
                throw new Error('Something went wrong while saving changes');
            }
        );
    }

    attemptSaveGeneral() {
        return this.rest.edit(this.model.id, {
            title: this.model.title,
            description: this.model.description,
            theme_id: this.model.theme_id
        });
    }

    attemptSavePublicOptions() {
        return this.rest.setPublicOptions(this.model.id, {
            public_enabled: this.model.public_options.public_enabled,
            moderation_contract: this.model.public_options.moderation_contract
        });
    }

    attemptSaveFeature(feature: CommunityFeaturesModel) {
        let request = {
            communityId: this.model.id,
            feature: feature.code
        };

        return feature.is_activated
            ? this.rest.activateFeature(request)
            : this.rest.deactivateFeature(request);
    }

    attemptSaveImage() {
        return this.rest.imageUpload(this.model.id, {
            file: this.model.new_image.uploadImage,
            crop: {
                x1: this.model.new_image.uploadImageCrop.x,
                y1: this.model.new_image.uploadImageCrop.y,
                x2: this.model.new_image.uploadImageCrop.width + this.model.new_image.uploadImageCrop.x,
                y2: this.model.new_image.uploadImageCrop.height + this.model.new_image.uploadImageCrop.y
            }
        })
    }

    isImageModified(): boolean {
        return !! this.model.new_image
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
