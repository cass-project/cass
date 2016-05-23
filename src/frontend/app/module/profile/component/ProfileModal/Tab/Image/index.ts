import {Component, Injectable} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
import {ProfileImage} from "../../../ProfileImage/index";
import {AvatarCropperService} from "../../../../../util/component/AvatarCropper/service";
import {ModalControl} from "../../../../../util/classes/ModalControl";
import {ProfileUploadImageModal} from "../../../ProfileUploadImageModal/index";

@Component({
    selector: 'cass-profile-modal-tab-image',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileImage,
        ProfileUploadImageModal,
    ],
    providers: [
        CORE_DIRECTIVES
    ]
})

@Injectable()
export class ImageTab
{
    upload: UploadImageModalControl = new UploadImageModalControl();

    uploadProfileImage() {
        this.upload.open();
    }
}

class UploadImageModalControl extends ModalControl {}