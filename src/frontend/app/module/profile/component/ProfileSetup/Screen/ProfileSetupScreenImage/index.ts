import {Component, Injectable} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";

import {AvatarCropperService} from "../../../../../util/component/AvatarCropper/service";

@Component({
    selector: 'cass-profile-setup-screen-image',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        AvatarCropperService
    ],
    directives: [
        CORE_DIRECTIVES,
    ]
})

@Injectable()
export class ProfileSetupScreenImage
{
    constructor(private avatarCropperService: AvatarCropperService){}

    isAvatarCropperVisible(){
        return this.avatarCropperService.isAvatarFormVisibleFlag;
    }

    showAvatarCropper() {
        this.avatarCropperService.isAvatarFormVisibleFlag = true;
    }

    private onFileChange(event) : void {
        this.avatarCropperService.file = event.target.files[0];
        this.avatarCropperService.imgPath = URL.createObjectURL(event.target.files[0]);
        this.showAvatarCropper();
    }
}