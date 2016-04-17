import {ResponseInterface} from '../../../module/common/ResponseInterface.ts';
import {Http, Response} from 'angular2/http';
import {Observable} from 'rxjs/Observable';
import {Injectable} from 'angular2/core';
import {URLSearchParams} from 'angular2/http';
import {Headers} from "angular2/http";
import {RequestOptions} from "angular2/http";

@Injectable()
export class CurrentProfileRestService{
    constructor(public http:Http) {}

    getProfileInfo(profileId){
        let url = `/backend/api/protected/profile/${profileId}/get`;

        return this.http.post(url, JSON.stringify({}));
    }

    greetingsAsFL(profileId ,firsname, lastname){
        return this.http.post('backend/api/protected/profile/' + profileId + '/greetings-as/fl/', JSON.stringify({first_name: firsname, last_name: lastname}));
    }

    greetingsAsFLM(profileId ,firstname, lastname, midlename){
        return this.http.post('backend/api/protected/profile/' + profileId + '/greetings-as/lfm/', JSON.stringify({last_name : lastname, first_name: firstname, middle_name: midlename}));
    }

    greetingsAsN(profileId, nick){
        return this.http.post('backend/api/protected/profile/' + profileId + '/greetings-as/n/', JSON.stringify({nickname: nick}));
    }

    avatarUpload(profileId, file: Blob, crop: Crop){
        let url = `/backend/api/protected/profile/${profileId}/image-upload/crop-start/${crop.start.x}/${crop.start.y}/crop-end/${crop.end.x}/${crop.end.y}`;
        let formData = new FormData();
            formData.append("file", file);

        let xmlRequest = new XMLHttpRequest();
        xmlRequest.open("POST", url);
        xmlRequest.send(formData);
    }
}

export class ProfileWelcomeInfo
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