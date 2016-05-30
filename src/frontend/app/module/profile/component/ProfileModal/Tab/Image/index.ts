import {Component, Injectable} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
import {ProfileImage} from "../../../ProfileImage/index";
import {ModalControl} from "../../../../../util/classes/ModalControl";
import {UploadImageModal} from "../../../../../util/component/UploadImage/index";
import {UploadImageService} from "../../../../../util/component/UploadImage/service";
import {UploadProfileImageStrategy} from "../../../../util/UploadProfileImageStrategy";
import {ProfileRESTService} from "../../../ProfileService/ProfileRESTService";
import {FrontlineService} from "../../../../../frontline/service";
import {AuthService} from "../../../../../auth/service/AuthService";


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
    deleteProcessVisible = false;

    constructor(private uploadImageService: UploadImageService, private frontlineService: FrontlineService, private profileRESTService: ProfileRESTService) {
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
            this.frontlineService.session.auth.profiles[0].image.public_path = '/public/assets/profile-default.png';
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