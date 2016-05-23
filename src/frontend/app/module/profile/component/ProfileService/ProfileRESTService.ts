var xmlRequest = new XMLHttpRequest();

import {Injectable} from 'angular2/core';
import {Http, URLSearchParams} from 'angular2/http';
import {AuthService} from "../../../auth/service/AuthService";
import {AvatarCropperService} from "../../../util/component/AvatarCropper/service";
import {FrontlineService} from "../../../frontline/service";
import {ThemeService} from "../../../theme/service/ThemeService";
import {ProfileService} from "./ProfileService";

@Injectable()
export class ProfileRESTService
{
    constructor(public http: Http, private avatarCropperService: AvatarCropperService,
                private frontlineService: FrontlineService,
                private themeService: ThemeService,
                private profileService: ProfileService){}

    public tryNumber: number = 0;
    public progressBar: number;

    editPersonal(){
        let url = `/backend/api/protected/profile/${this.frontlineService.session.auth.profiles[0].id}/edit-personal/`;

        this.frontlineService.session.auth.profiles[0].greetings.greetings_method = this.profileService.greetings.greetings_method;
        this.frontlineService.session.auth.profiles[0].greetings.last_name =  this.profileService.greetings.last_name;
        this.frontlineService.session.auth.profiles[0].greetings.first_name =  this.profileService.greetings.first_name;
        this.frontlineService.session.auth.profiles[0].greetings.middle_name =  this.profileService.greetings.middle_name;
        this.frontlineService.session.auth.profiles[0].greetings.nickname =  this.profileService.greetings.nickname;

        return this.http.post(url, JSON.stringify({
            greetings_method: this.profileService.greetings.greetings_method,
            last_name: this.profileService.greetings.last_name,
            first_name: this.profileService.greetings.first_name,
            middle_name: this.profileService.greetings.middle_name,
            nickname: this.profileService.greetings.nickname
        }));
    }

    updateExpertThemes(){
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/expert-in`;

        this.frontlineService.session.auth.profiles[0].expert_in = (JSON.parse(JSON.stringify(this.profileService.expertIn)));

        return this.http.put(url, JSON.stringify({
            theme_ids: this.profileService.expertIn
        }));
    }

    updateInterestThemes(){
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/interesting-in`;

        this.frontlineService.session.auth.profiles[0].interesting_in = (JSON.parse(JSON.stringify(this.profileService.interestingIn)));

        return this.http.put(url, JSON.stringify({
            theme_ids: this.profileService.interestingIn
        }));
    }


    requestAccountDeleteCancel(){
        let url = `/backend/api/protected/account/cancel-request-delete`;

        return this.http.delete(url);
    }

    requestAccountDelete(){
        let url = `/backend/api/protected/account/request-delete`;

        return this.http.put(url, JSON.stringify(''));
    }

    changePassword(){
        let url = `/backend/api/protected/account/change-password`;

        return this.http.post(url, JSON.stringify({
            old_password: this.profileService.changePasswordStn.old_password,
            new_password: this.profileService.changePasswordStn.new_password
        }));
    }

    avatarUpload() {
        let crop = this.avatarCropperService.crop;

        this.tryNumber++;
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/image-upload/crop-start/${crop.start.x}/${crop.start.y}/crop-end/${crop.end.x}/${crop.end.y}`;
        let formData = new FormData();
        formData.append("file", this.avatarCropperService.file);

        xmlRequest.open("POST", url);
        xmlRequest.upload.onprogress = (e) => {
            if (e.lengthComputable) {
                this.progressBar  = Math.floor((e.loaded / e.total) * 100);
            }
        };

        xmlRequest.send(formData);

        xmlRequest.onreadystatechange = () => {
            if (xmlRequest.readyState === 4) {
                if (xmlRequest.status === 200) {
                    //this.avatarCropperService.isAvatarFormVisibleFlag = false;
                    AuthService.getAuthToken().getCurrentProfile().entity.image.public_path = JSON.parse(xmlRequest.responseText).public_path;
                    this.progressBar = 0;
                    this.tryNumber = 0;
                } else {
                    this.avatarUpload();
                }
            }
        }
    }
}