import {Component, Injectable} from "@angular/core";

import {ModalControl} from "../../../../../../common/classes/ModalControl";
import {UploadProfileImageStrategy} from "../../../../../common/UploadProfileImageStrategy";
import {ProfileRESTService} from "../../../../../service/ProfileRESTService";
import {UploadImageService} from "../../../../../../common/component/UploadImage/service";
import {Session} from "../../../../../../session/Session";
import {queryImage, QueryTarget} from "../../../../../../avatar/functions/query";

@Component({
    selector: 'cass-profile-modal-tab-image',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        UploadImageService,
    ]
})
@Injectable()
export class ImageTab
{
    private upload: UploadImageModalControl = new UploadImageModalControl();
    private deleting = false;

    constructor(
        private uploadImageService: UploadImageService, 
        private profileRESTService: ProfileRESTService,
        private session: Session
    ) {
        uploadImageService.setUploadStrategy(new UploadProfileImageStrategy(
            session.getCurrentProfile().entity.profile,
            this.profileRESTService
        ));
    }

    getImageProfile() {
        return queryImage(QueryTarget.Biggest, this.session.getCurrentProfile().entity.profile.image);
    }

    deleteProfileImage() {
        this.deleting = true;
        let profileId = this.session.getCurrentProfile().entity.profile.id;
        
        this.profileRESTService.imageDelete(profileId).subscribe(response => {
            this.session.getCurrentProfile().entity.profile.image = response.image;
            this.deleting = false;
        }, error => {
            this.deleting = false;
        });
    }

    uploadProfileImage() {
        this.upload.open();
    }
}

class UploadImageModalControl extends ModalControl {}