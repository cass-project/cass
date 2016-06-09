import {Component} from "angular2/core";

import {ImageCropper, ImageCropperService} from "../../../../../../util/component/ImageCropper/index";
import {CommunityCreateModalModel} from "../../../CommunityCreateModal/model";

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
        ImageCropper
    ]
})

export class ImageTab {

    private uploadImage;

    constructor(public cropper: ImageCropperService) {
    }

    onFileChange($event) {
        this.cropper.reset();
        setTimeout(()=>{
            this.uploadImage = $event.target.files[0];
            this.cropper.setFile(this.uploadImage);
        },0)
    }

}