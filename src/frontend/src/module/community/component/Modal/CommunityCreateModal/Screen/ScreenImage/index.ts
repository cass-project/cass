import {Component} from "angular2/core";

import {Screen} from "../../screen";
import {CommunityCreateModalModel} from "../../model";
import {CommunityCreateModalForm} from "../../Form";
import {ImageCropperService, ImageCropper} from "../../../../../../form/component/ImageCropper/index";
import {UploadImageCropModel} from "../../../../../../form/component/UploadImage/strategy";

@Component({
    selector: 'cass-community-create-modal-screen-image',
    template: require('./template.jade'),
    providers: [
        ImageCropperService
    ],
    directives: [
        ImageCropper,
        CommunityCreateModalForm
    ]
})
export class ScreenImage extends Screen
{

    constructor(public model: CommunityCreateModalModel, private cropper: ImageCropperService) {
        super();
    }

    onFileChange($event) {
        this.cropper.reset();
        setTimeout(() => {
            this.model.uploadImage = $event.target.files[0];
            this.cropper.setFile(this.model.uploadImage);
        }, 0)
    }

    next() {
        if(this.cropper.hasCropper()) {
            this.model.uploadImageCrop = <UploadImageCropModel>{
                x: this.cropper.getX(),
                y: this.cropper.getY(),
                width: this.cropper.getWidth(),
                height: this.cropper.getHeight()
            };
        }
        this.nextEvent.emit(this);
    }
}