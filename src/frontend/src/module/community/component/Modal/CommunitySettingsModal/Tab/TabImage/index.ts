import {Component, ViewChild} from "@angular/core";

import {CommunitySettingsModalModel} from "../../model";
import {ImageCropperService} from "../../../../../../form/component/ImageCropper/index";
import {UploadImageCropModel} from "../../../../../../form/component/UploadImage/strategy";
import {CommunityRESTService} from "../../../../../service/CommunityRESTService";
import {CommunityImageDeleteRequest} from "../../../../../definitions/paths/image-delete";

@Component({
    selector: 'cass-community-settings-modal-tab-image',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityImageTab
{
    constructor(
        public model: CommunitySettingsModalModel,
        public cropper: ImageCropperService,
        public modelUnmodified: CommunitySettingsModalModel,
        private service: CommunityRESTService
    ) {
        this.setImage();
    }

    @ViewChild('communityImageUploadInput') communityImageUploadInput;

    private loading:boolean = false;

    setImage() {
        if(this.model.new_image) {
            this.cropper.options.data = JSON.parse(JSON.stringify(this.model.new_image.uploadImageCrop));
            this.cropper.setFile(this.model.new_image.uploadImage);
        }
    }

    onSelect($event) {
        delete this.cropper.options.data; // При выборе новой картинки стираем crop data от старой
        this.cropper.setFile($event.target.files[0]);
        this.communityImageUploadInput.nativeElement.value=""; // Для корректной работы input onchange 
    }
    
    onChange() {
        this.model.new_image = {
            uploadImage: this.cropper.getFile(),
            uploadImageCrop:<UploadImageCropModel>{
                x: this.cropper.getX(),
                y: this.cropper.getY(),
                width: this.cropper.getWidth(),
                height: this.cropper.getHeight()
            }
        }
    }

    cancel() {
        delete this.model['new_image'];
        this.cropper.reset();
    }

    deleteImage() {
        this.loading = true;
        this.service.imageDelete(<CommunityImageDeleteRequest>{communityId:this.model.id})
            .map(data=>data.json())
            .subscribe(
                data => {
                    this.loading = false;
                    this.model.image = JSON.parse(JSON.stringify(data.image));
                    this.modelUnmodified.image = JSON.parse(JSON.stringify(data.image));
                    this.setImage();
                }
            )
    }
}