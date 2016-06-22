import {Component, Injectable} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
import {ProfileImage} from "../../../ProfileImage/index";
import {ModalControl} from "../../../../../util/classes/ModalControl";
import {UploadProfileImageStrategy} from "../../../../util/UploadProfileImageStrategy";
import {ProfileRESTService} from "../../../../service/ProfileRESTService";
import {AuthService} from "../../../../../auth/service/AuthService";
import {UploadImageModal} from "../../../../../form/component/UploadImage/index";
import {UploadImageService} from "../../../../../form/component/UploadImage/service";


@Component({
    selector: 'cass-profile-modal-tab-image',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileImage,
        UploadImageModal,
    ],
    providers: [
        CORE_DIRECTIVES,
        UploadImageService
    ]
})

@Injectable()
export class ImageTab
{
    upload: UploadImageModalControl = new UploadImageModalControl();
    private deleteProcessVisible = false;

    constructor(private uploadImageService: UploadImageService, private profileRESTService: ProfileRESTService) {
        uploadImageService.setUploadStrategy(new UploadProfileImageStrategy(profileRESTService));
    }


    getImageProfile(){
        if(AuthService.isSignedIn()){
            return AuthService.getAuthToken().getCurrentProfile().entity.profile.image.variants['default'].public_path;
        }
    }

    avatarDeletingProcess(){
        this.deleteProcessVisible = true;
        this.profileRESTService.deleteAvatar().subscribe(data => {
            AuthService.getAuthToken().getCurrentProfile().entity.profile.image = {
                "variants": {
                    "default": {
                        "id": 'default',
                        "public_path": '/public/assets/profile-default.png'
                    }
                }
            };
            this.deleteProcessVisible = false;
        });
    }



    uploadProfileImage() {
        this.upload.open();
    }

    closeUploadProfileImageModal() {
        console.log('close???');
        this.upload.close();
    }
}

class UploadImageModalControl extends ModalControl {}