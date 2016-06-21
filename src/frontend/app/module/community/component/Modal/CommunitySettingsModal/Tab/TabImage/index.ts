import {Component} from "angular2/core";

import {ImageCropper, ImageCropperService} from "../../../../../../util/component/ImageCropper";
import {CommunitySettingsModalModel} from "../../model";
import {CommunityImage} from "../../../../Elements/CommunityImage/index";
import {UploadImageCropModel} from "../../../../../../util/component/UploadImage/strategy";

@Component({
    selector: 'cass-community-settings-modal-tab-image',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ImageCropperService
    ],
    directives: [
        ImageCropper,
        CommunityImage
    ]
})

export class ImageTab {

    constructor(public model: CommunitySettingsModalModel, public cropper: ImageCropperService) {}

    onSelect($event) {
        this.cropper.reset();
        setTimeout(()=> {
            this.cropper.setFile($event.target.files[0]);
        }, 0);
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
}