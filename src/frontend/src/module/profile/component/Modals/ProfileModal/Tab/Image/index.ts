import {Component, Injectable} from "@angular/core";
import {CORE_DIRECTIVES} from "@angular/common";

import {ProfileImage} from "../../../../Elements/ProfileImage/index";
import {ModalControl} from "../../../../../../common/classes/ModalControl";
import {UploadProfileImageStrategy} from "../../../../../common/UploadProfileImageStrategy";
import {ProfileRESTService} from "../../../../../service/ProfileRESTService";
import {AuthService} from "../../../../../../auth/service/AuthService";
import {UploadImageModal} from "../../../../../../form/component/UploadImage/index";
import {UploadImageService} from "../../../../../../form/component/UploadImage/service";
import {AuthToken} from "../../../../../../auth/service/AuthToken";
import {CurrentProfileService} from "../../../../../service/CurrentProfileService";

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
        private authToken: AuthToken,
        private currentProfileService: CurrentProfileService
    ) {
        uploadImageService.setUploadStrategy(new UploadProfileImageStrategy(
            currentProfileService.get().entity.profile,
            authToken.getAPIKey()
        ));
    }

    getImageProfile(){
        if(this.authService.isSignedIn()){
            return this.currentProfileService.get().entity.profile.image.variants['512'].public_path;
        }
    }

    avatarDeletingProcess(){
        this.deleteProcessVisible = true;
        let profileId = this.currentProfileService.get().entity.profile.id;
        
        this.profileRESTService.deleteAvatar(profileId).subscribe(response => {
            this.currentProfileService.get().entity.profile.image = response.image;
            this.deleteProcessVisible = false;
        });
    }



    uploadProfileImage() {
        this.upload.open();
    }

    closeUploadProfileImageModal() {
        this.upload.close();
    }
}

class UploadImageModalControl extends ModalControl {}