import {UploadProfileImageStrategy} from "../../util/UploadProfileImageStrategy";
var xmlRequest = new XMLHttpRequest();

import {Injectable} from 'angular2/core';
import {Http, URLSearchParams} from 'angular2/http';
import {AuthService} from "../../../auth/service/AuthService";

@Injectable()
export class ProfileRESTService {
    constructor(public http:Http) {
    }

    public tryNumber:number = 0;
    public progressBar:number = 0;


    getProfileById(profileId){
        let url = `/backend/api/profile/${profileId}/get`;

        return this.http.get(url);
    }

    createNewProfile(){
        let url = `/backend/api/protected/profile/create`;

        return this.http.put(url, JSON.stringify({}));
    }

    editSex(profile) {
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/set-gender`;

        AuthService.getAuthToken().getCurrentProfile().entity.gender = profile.gender;

        console.log(profile.gender.string);
        return this.http.post(url, JSON.stringify({
            gender: profile.gender.string
        }))
    }

    editPersonal(profile) {
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/edit-personal/`;

        AuthService.getAuthToken().getCurrentProfile().entity.greetings.greetings_method = profile.greetings.greetings_method;
        AuthService.getAuthToken().getCurrentProfile().entity.greetings.last_name = profile.greetings.last_name;
        AuthService.getAuthToken().getCurrentProfile().entity.greetings.first_name = profile.greetings.first_name;
        AuthService.getAuthToken().getCurrentProfile().entity.greetings.middle_name = profile.greetings.middle_name;
        AuthService.getAuthToken().getCurrentProfile().entity.greetings.nickname = profile.greetings.nickname;
        AuthService.getAuthToken().getCurrentProfile().entity.gender = profile.gender;

        let log = {gender: profile.gender,
            greetings_method: profile.greetings.greetings_method,
            last_name: profile.greetings.last_name,
            first_name: profile.greetings.first_name,
            middle_name: profile.greetings.middle_name,
            nickname: profile.greetings.nickname
        };
        console.log(log, profile);

        return this.http.post(url, JSON.stringify({
            gender: profile.gender,
            greetings_method: profile.greetings.greetings_method,
            last_name: profile.greetings.last_name,
            first_name: profile.greetings.first_name,
            middle_name: profile.greetings.middle_name,
            nickname: profile.greetings.nickname
        }));
    }

    updateExpertThemes(expertIn) {
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/expert-in`;

        AuthService.getAuthToken().getCurrentProfile().entity.expert_in = (JSON.parse(JSON.stringify(expertIn)));

        return this.http.put(url, JSON.stringify({
            theme_ids: expertIn
        }));
    }

    updateInterestThemes(interestingIn) {
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/interesting-in`;

        AuthService.getAuthToken().getCurrentProfile().entity.interesting_in = (JSON.parse(JSON.stringify(interestingIn)));

        return this.http.put(url, JSON.stringify({
            theme_ids: interestingIn
        }));
    }


    requestAccountDeleteCancel() {
        let url = `/backend/api/protected/account/cancel-request-delete`;

        return this.http.delete(url);
    }

    requestAccountDelete() {
        let url = `/backend/api/protected/account/request-delete`;

        return this.http.put(url, JSON.stringify(''));
    }

    changePassword(changePasswordStn) {
        let url = `/backend/api/protected/account/change-password`;

        return this.http.post(url, JSON.stringify({
            old_password: changePasswordStn.old_password,
            new_password: changePasswordStn.new_password
        }));
    }


    signOut() {
        let url = `/backend/api/auth/sign-out/`;
        return this.http.get(url).subscribe(data => {
            window.location.reload()
        });
    }

    deleteAvatar() {
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/image-delete`;

        return this.http.delete(url);
    }

    avatarUpload(file, model, modal) {

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
                this.progressBar = Math.floor((e.loaded / e.total) * 100);
                modal.progress.update(this.progressBar);

            }
        };

        xmlRequest.send(formData);

        xmlRequest.onreadystatechange = () => {
            if (xmlRequest.readyState === 4) {
                if (xmlRequest.status === 200) {
                    AuthService.getAuthToken().getCurrentProfile().entity.image.public_path = JSON.parse(xmlRequest.responseText).public_path;
                    modal.progress.complete();
                    modal.close();
                    this.progressBar = 0;
                    this.tryNumber = 0;
                } else {
                    this.avatarUpload(file, model, modal);
                }
            }
        }
    }
}