import {Component, Injectable} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {AvatarCropper} from "../../../../util/component/AvatarCropper/index";
import {AvatarCropperService} from "../../../../util/component/AvatarCropper/service";

@Component({
    selector: 'cass-profile-settings-image',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        AvatarCropperService
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CORE_DIRECTIVES,
        /*AvatarCropper*/
    ]
})

@Injectable()
export class ProfileSettingsImage
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