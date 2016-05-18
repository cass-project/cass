import {Component, Injectable} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {ProfileImage} from "../../../ProfileImage/index";
import {AvatarCropperService} from "../../../../../util/component/AvatarCropper/service";
import {AvatarCropper} from "../../../../../util/component/AvatarCropper/index";

enum ImageTabStage {
    View = <any>"View",
    File = <any>"File",
    Crop = <any>"Crop",
    Processing = <any>"Processing"
}

@Component({
    selector: 'cass-profile-modal-tab-image',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileImage,
        AvatarCropper
    ],
    providers: [
        ROUTER_DIRECTIVES,
        CORE_DIRECTIVES,
        AvatarCropperService
    ]
})

@Injectable()
export class ImageTab
{
    constructor(private avatarCropperService: AvatarCropperService){}


    isAvatarCropperVisible(){
        console.log(this.avatarCropperService.isAvatarFormVisibleFlag);
        return this.avatarCropperService.isAvatarFormVisibleFlag;
    }

    showAvatarCropper() {
        this.avatarCropperService.isAvatarFormVisibleFlag = true;
    }

    private onFileChange(event) : void {
        this.avatarCropperService.profileAvatar = true;
        this.avatarCropperService.file = event.target.files[0];
        this.avatarCropperService.imgPath = URL.createObjectURL(event.target.files[0]);
        console.log(this.avatarCropperService.imgPath, this.avatarCropperService.file);
        this.cropProfileImage();
    }



    stage: ImageTabCurrentStage = new ImageTabCurrentStage();

    uploadProfileImage() {
        this.stage.go(ImageTabStage.File);
    }

    cropProfileImage() {
        this.stage.go(ImageTabStage.Crop);
    }

    processUploadProfileImage() {
        this.stage.go(ImageTabStage.Processing);
    }
}

class ImageTabCurrentStage
{
    static DEFAULT_STAGE = ImageTabStage.View;

    public current: ImageTabStage = ImageTabCurrentStage.DEFAULT_STAGE;

    go(tab: ImageTabStage) {
        this.current = tab;
    }

    isOn(tab: ImageTabStage) {
        return this.current === tab;
    }
}