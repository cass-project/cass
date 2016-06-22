import {Component} from "angular2/core";

import {CommunitySettingsModalModel} from "../../model";
import {CommunityImage} from "../../../../Elements/CommunityImage/index";
import {ImageCropperService, ImageCropper} from "../../../../../../form/component/ImageCropper/index";
import {UploadImageCropModel} from "../../../../../../form/component/UploadImage/strategy";
import {CommunityEnityImage} from "../../../../../definitions/entity/Community";
import {CommunityRESTService} from "../../../../../service/CommunityRESTService";
import {CommunityImageDeleteRequest} from "../../../../../definitions/paths/image-delete";

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

    private loading:boolean = false;

    constructor(
        public model: CommunitySettingsModalModel,
        public cropper: ImageCropperService,
        private service:CommunityRESTService
    ) {
        this.setImage();
    }

    setImage() {
        if(this.model.new_image) {
            this.cropper.options.data = JSON.parse(JSON.stringify(this.model.new_image.uploadImageCrop));
            this.cropper.setFile(this.model.new_image.uploadImage);
        }
    }

    onSelect($event) {
        this.cropper.setFile($event.target.files[0]);
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
        delete this.model.new_image.uploadImage;
        delete this.model.new_image.uploadImageCrop;
        this.cropper.reset();
    }

    delete_image() {
        this.loading = true;
        this.service.imageDelete(<CommunityImageDeleteRequest>{communityId:this.model.id})
            .map(data=>data.json())
            .subscribe(
                data => {
                    this.loading = false;
                    this.model.image = data.image;
                    this.setImage();
                    console.log(data);
                }
            )
    }
}