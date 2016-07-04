import {Component, Injectable} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";

import {ProfileImage} from "../../../../Elements/ProfileImage/index";
import {ModalControl} from "../../../../../../util/classes/ModalControl";
import {UploadProfileImageStrategy} from "../../../../../util/UploadProfileImageStrategy";
import {ProfileRESTService} from "../../../../../service/ProfileRESTService";
import {AuthService} from "../../../../../../auth/service/AuthService";
import {UploadImageModal} from "../../../../../../form/component/UploadImage/index";
import {UploadImageService} from "../../../../../../form/component/UploadImage/service";
import {AuthToken} from "../../../../../../auth/service/AuthToken";

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
        UploadImageService,
    ]
})

@Injectable()
export class ImageTab
{
    upload: UploadImageModalControl = new UploadImageModalControl();
    private deleteProcessVisible = false;

    constructor(
        private uploadImageService: UploadImageService, 
        private profileRESTService: ProfileRESTService,
        private authService: AuthService,
        private authToken: AuthToken
    ) {
        uploadImageService.setUploadStrategy(new UploadProfileImageStrategy(
            authService.getCurrentAccount().getCurrentProfile().entity.profile,
            authToken.getAPIKey()
        ));
    }


    getImageProfile(){
        if(this.authService.isSignedIn()){
            return this.authService.getCurrentAccount().getCurrentProfile().entity.profile.image.variants['default'].public_path;
        }
    }

    avatarDeletingProcess(){
        this.deleteProcessVisible = true;
        let profileId = this.authService.getCurrentAccount().getCurrentProfile().entity.profile.id;
        
        this.profileRESTService.deleteAvatar(profileId).subscribe(data => {
            this.authService.getCurrentAccount().getCurrentProfile().entity.profile.image = {
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