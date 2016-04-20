var xmlRequest = new XMLHttpRequest();

import {ResponseInterface} from '../../../module/common/ResponseInterface.ts';
import {Http, Response} from 'angular2/http';
import {Observable} from 'rxjs/Observable';
import {Injectable} from 'angular2/core';
import {URLSearchParams} from 'angular2/http';
import {Headers} from "angular2/http";
import {RequestOptions} from "angular2/http";
import {AvatarCropperService} from "../component/AvatarCropper/service";
import {AuthService} from "../../auth/service/AuthService";

var avatarLoadEnd = false;

@Injectable()
export class ProfileService {
    constructor(public http:Http,
                public avatarCropperService:AvatarCropperService
    ) {
    }

    getProfileInfo() {
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/get`;

        return this.http.post(url, JSON.stringify({}));
    }

    greetingsAsFL(firstname, lastname) {
        let url = `backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/greetings-as/fl/`;

        AuthService.getAuthToken().getCurrentProfile().entity.greetings.greetings_method = 'fl';
        AuthService.getAuthToken().getCurrentProfile().entity.greetings.first_name = firstname;
        AuthService.getAuthToken().getCurrentProfile().entity.greetings.last_name = lastname;

        return this.http.post(url, JSON.stringify({
            first_name: firstname,
            last_name: lastname
        }));
    }

    greetingsAsFLM(firstname, lastname, middlename) {
        let url =`backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/greetings-as/lfm/`;

        AuthService.getAuthToken().getCurrentProfile().entity.greetings.greetings_method = 'flm';
        AuthService.getAuthToken().getCurrentProfile().entity.greetings.first_name = firstname;
        AuthService.getAuthToken().getCurrentProfile().entity.greetings.last_name = lastname;
        AuthService.getAuthToken().getCurrentProfile().entity.greetings.middle_name = middlename;

        return this.http.post(url, JSON.stringify({
            last_name: lastname,
            first_name: firstname,
            middle_name: middlename
        }));
    }

    checkInitProfile(){
       return AuthService.getAuthToken().getCurrentProfile().entity.is_initialized;
    }

    greetingsAsN(nickname) {
        let url = `backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/greetings-as/n/`;

        AuthService.getAuthToken().getCurrentProfile().entity.greetings.greetings_method = 'n';
        AuthService.getAuthToken().getCurrentProfile().entity.greetings.nickname = nickname;

        return this.http.post(url, JSON.stringify({nickname: nickname}));
    }

    avatarUpload(file:Blob, crop:Crop) {
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/image-upload/crop-start/${crop.start.x}/${crop.start.y}/crop-end/${crop.end.x}/${crop.end.y}`;
        let formData = new FormData();
        formData.append("file", file);

        xmlRequest.open("POST", url);
        xmlRequest.send(formData);
        xmlRequest.onreadystatechange = () => {
            if (xmlRequest.readyState === 4) {
                if (xmlRequest.status === 200) {
                    this.avatarCropperService.isAvatarFormVisibleFlag = false;
                    AuthService.getAuthToken().getCurrentProfile().entity.image.public_path = JSON.parse(xmlRequest.responseText).public_path;
                }
            }
        }
    }
}

export class ProfileNameInfo
{
    nickname: string;
    firstname: string;
    lastname: string;
    middlename: string;
}

export interface Crop
{
    start: {
        x: number;
        y: number;
    },
    end: {
        x: number;
        y: number;
    }
}