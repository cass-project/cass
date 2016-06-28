import {Component, Injectable} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
import {ProfileRESTService} from "../../../../service/ProfileRESTService";
import {ProfileImage} from "../../../ProfileImage/index";
import {AuthService} from "../../../../../auth/service/AuthService";
import {ModalControl} from "../../../../../util/classes/ModalControl";
import {UploadProfileImageStrategy} from "../../../../util/UploadProfileImageStrategy";
import {UploadImageService} from "../../../../../form/component/UploadImage/service";
import {UploadImageModal} from "../../../../../form/component/UploadImage/index";

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
        UploadImageService,
        UploadProfileImageStrategy,
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

    constructor(
        private uploadImageService: UploadImageService, 
        private profileRESTService: ProfileRESTService,
        private uploadProfileImageStrategy: UploadProfileImageStrategy,
        private authService: AuthService
    ) {
        uploadImageService.setUploadStrategy(uploadProfileImageStrategy);
    }

    getImageProfile(){
        if(this.authService.isSignedIn()){
            return this.authService.getAuthToken().getCurrentProfile().entity.profile.image.variants['default'].public_path;
        }
    }

    avatarDeletingProcess(){
        this.deleteProcessVisible = true;
        let profileId = this.authService.getAuthToken().getCurrentProfile().entity.profile.id;
        
        this.profileRESTService.deleteAvatar(profileId).subscribe(data => {
            this.authService.getAuthToken().getCurrentProfile().entity.profile.image = {
                "variants": {
                    "default": {
                        "id": 'default',
                        public_path: '/public/assets/profile-default.png'
                    }
                }
            };
            this.deleteProcessVisible = false;
        });
    }

    uploadProfileImage() {
        this.upload.open();
    }
}

class UploadImageModalControl extends ModalControl {}