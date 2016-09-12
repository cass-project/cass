import {Component, Injectable, Output, EventEmitter, Directive} from "@angular/core";

import {UploadImageService} from "../../../../../../form/component/UploadImage/service";
import {UploadProfileImageStrategy} from "../../../../../common/UploadProfileImageStrategy";
import {ProfileImage} from "../../../../Elements/ProfileImage/index";
import {UploadImageModal} from "../../../../../../form/component/UploadImage/index";
import {ProfileRESTService} from "../../../../../service/ProfileRESTService";
import {ModalControl} from "../../../../../../common/classes/ModalControl";
import {ProfileSetupModel} from "../../model";
import {DeleteProfileImageResponse200} from "../../../../../definitions/paths/image-delete";
import {AuthToken} from "../../../../../../auth/service/AuthToken";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        UploadImageService,
    ]
})
@Directive({selector: 'cass-profile-setup-screen-image'})

@Injectable()
export class ProfileSetupScreenImage
{
    @Output('back') backEvent = new EventEmitter<ProfileSetupModel>();
    @Output('next') nextEvent = new EventEmitter<ProfileSetupModel>();

    upload: ModalControl = new ModalControl();
    isDeleting: boolean = false;

    constructor(
        private model: ProfileSetupModel,
        private uploadImageService: UploadImageService, 
        private profileRESTService: ProfileRESTService,
        private authToken: AuthToken
    ) {
        uploadImageService.setUploadStrategy(new UploadProfileImageStrategy(model.getProfile(), authToken.getAPIKey()));
    }

    next() {
        this.nextEvent.emit(this.model);
    }

    back() {
        this.backEvent.emit(this.model);
    }

    skip() {
        this.nextEvent.emit(this.model);
    }

    getProfileImage(): string {
        return this.model.getProfileImage().public_path;
    }

    deleteAvatar(){
        this.isDeleting = true;
        
        this.profileRESTService
            .deleteAvatar(this.model.getProfile().id)
            .subscribe(
                (response: DeleteProfileImageResponse200) => {
                    this.isDeleting = false;
                },
                (error) => {
                    this.isDeleting = false;
                }
            )
    }

    uploadProfileImage() {
        this.upload.open();
    }
}