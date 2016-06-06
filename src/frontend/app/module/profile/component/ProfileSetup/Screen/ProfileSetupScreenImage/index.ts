import {Component, Injectable} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
import {ImageCropperService} from "../../../../../util/component/ImageCropper/index";
import {UploadImageService} from "../../../../../util/component/UploadImage/service";
import {ImageCropper} from "../../../../../util/component/ImageCropper/index";
import {ScreenControls} from "../../../../../util/classes/ScreenControls";
import {UploadImageCropModel} from "../../../../../util/component/UploadImage/strategy";
import {ProfileRESTService} from "../../../ProfileService/ProfileRESTService";
import {ProfileImage} from "../../../ProfileImage/index";
import {AuthService} from "../../../../../auth/service/AuthService";
import {UploadImageModal} from "../../../../../util/component/UploadImage/index";
import {UploadImageService} from "../../../../../util/component/UploadImage/service";
import {ModalControl} from "../../../../../util/classes/ModalControl";
import {UploadProfileImageStrategy} from "../../../../util/UploadProfileImageStrategy";

enum UploadImageScreen {
    File = <any>"File",
    Crop = <any>"Crop",
    Processing = <any>"Processing"
}

@Component({
    selector: 'cass-profile-setup-screen-image',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        UploadImageService
    ],
    directives: [
        CORE_DIRECTIVES,
        ProfileImage,
        UploadImageModal,
    ]
})


@Injectable()
export class ProfileSetupScreenImage
{
    upload: UploadImageModalControl = new UploadImageModalControl();
    deleteProcessVisible: boolean = false;

    constructor(private uploadImageService: UploadImageService, private profileRESTService: ProfileRESTService) {
        uploadImageService.setUploadStrategy(new UploadProfileImageStrategy(profileRESTService));
    }

    getImageProfile(){
        if(AuthService.isSignedIn()){
            return AuthService.getAuthToken().getCurrentProfile().entity.image.public_path;
        }
    }

    avatarDeletingProcess(){
        this.deleteProcessVisible = true;
        this.profileRESTService.deleteAvatar().subscribe(data => {
            AuthService.getAuthToken().getCurrentProfile().entity.image.public_path = '/public/assets/profile-default.png';
            this.deleteProcessVisible = false;
        });
    }

    uploadProfileImage() {
        this.upload.open();
    }
}

class UploadImageModalControl extends ModalControl {}