import {Component} from "angular2/core";
import {AvatarCropper} from "../../../../util/component/AvatarCropper/index";
import {AvatarCropperService} from "../../../../util/component/AvatarCropper/service";

@Component({
    selector: 'cass-profile-settings-image',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        AvatarCropper
    ]
})
export class ProfileSettingsImage
{
    constructor(private avatarCropperService: AvatarCropperService){}



    showAvatarCropper() {
        this.avatarCropperService.isAvatarFormVisibleFlag = true;
    }

}