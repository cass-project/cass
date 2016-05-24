var xmlRequest = new XMLHttpRequest();

import {Injectable} from 'angular2/core';
import {Http, URLSearchParams} from 'angular2/http';
import {AuthService} from "../../../auth/service/AuthService";
import {AvatarCropperService} from "../../../util/component/AvatarCropper/service";
import {FrontlineService} from "../../../frontline/service";

@Injectable()
export class ProfileRESTService
{
    constructor(public http: Http,
                private avatarCropperService: AvatarCropperService,
                private frontlineService: FrontlineService){}

    public tryNumber: number = 0;
    public progressBar: number;


    editSex(profile){
        let url = `/backend/api/protected/profile/${this.frontlineService.session.auth.profiles[0].id}/set-gender`;

        this.frontlineService.session.auth.profiles[0].gender = profile.gender;

        console.log(profile.gender.string);
        return this.http.post(url, JSON.stringify({
            gender: profile.gender.string
        }))
    }

    editPersonal(profile){
        let url = `/backend/api/protected/profile/${this.frontlineService.session.auth.profiles[0].id}/edit-personal/`;

        this.frontlineService.session.auth.profiles[0].greetings.greetings_method = profile.greetings.greetings_method;
        this.frontlineService.session.auth.profiles[0].greetings.last_name =  profile.greetings.last_name;
        this.frontlineService.session.auth.profiles[0].greetings.first_name =  profile.greetings.first_name;
        this.frontlineService.session.auth.profiles[0].greetings.middle_name =  profile.greetings.middle_name;
        this.frontlineService.session.auth.profiles[0].greetings.nickname =  profile.greetings.nickname;


        return this.http.post(url, JSON.stringify({
            greetings_method: profile.greetings.greetings_method,
            last_name: profile.greetings.last_name,
            first_name: profile.greetings.first_name,
            middle_name: profile.greetings.middle_name,
            nickname: profile.greetings.nickname
        }));
    }

    updateExpertThemes(expertIn){
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/expert-in`;

        this.frontlineService.session.auth.profiles[0].expert_in = (JSON.parse(JSON.stringify(expertIn)));

        return this.http.put(url, JSON.stringify({
            theme_ids: expertIn
        }));
    }

    updateInterestThemes(interestingIn){
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/interesting-in`;

        this.frontlineService.session.auth.profiles[0].interesting_in = (JSON.parse(JSON.stringify(interestingIn)));

        return this.http.put(url, JSON.stringify({
            theme_ids: interestingIn
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

    changePassword(changePasswordStn){
        let url = `/backend/api/protected/account/change-password`;

        return this.http.post(url, JSON.stringify({
            old_password: changePasswordStn.old_password,
            new_password: changePasswordStn.new_password
        }));
    }

    avatarUpload(file, model) {

        let crop = {
            start: {
                x: model.x,
                y: model.y
            },
            end: {
                x: model.width + model.x,
                y: model.height + model.y
            }
        };

        this.tryNumber++;
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/image-upload/crop-start/${crop.start.x}/${crop.start.y}/crop-end/${crop.end.x}/${crop.end.y}`;
        let formData = new FormData();
        formData.append("file", file);

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
                    this.avatarUpload(file, model);
                }
            }
        }
    }
}