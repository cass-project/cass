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
import {ThemeSelector} from "../../theme/component/ThemeSelector/component";
import {ThemeService} from "../../theme/service/ThemeService";

@Injectable()
export class ProfileService {
    constructor(public http:Http,
                public avatarCropperService:AvatarCropperService,
                public themeService: ThemeService
    ){}

    public crop;
    public file;
    public tryNumber: number = 0;
    public progressBar: number;
    public profileInfo: ProfileInfo = new ProfileInfo();

    getProfileInfo() {
        let url = `/backend/api/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/get`;

        return this.http.get(url);
    }

    greetingsAsFL() {
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;
        let url = `backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/greetings-as/fl/`;

        return this.http.post(url, JSON.stringify({
            first_name: greetings.first_name,
            last_name: greetings.last_name
        }));
    }

    greetingsAsFLM() {
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;
        let url =`backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/greetings-as/lfm/`;

        return this.http.post(url, JSON.stringify({
            last_name: greetings.last_name,
            first_name: greetings.first_name,
            middle_name: greetings.middle_name
        }));
    }

    static checkInitProfile(){
       return AuthService.getAuthToken().getCurrentProfile().entity.is_initialized;
    }

    greetingsAsN() {
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;
        let url = `backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/greetings-as/n/`;

        return this.http.post(url, JSON.stringify({
            nickname: greetings.nickname
        }));
    }

    getSelectedThemesIds(){
        let arrayPush = [];

        for(let i = 0; i < this.themeService.selectedThemes.length; i++){
            arrayPush.push(this.themeService.selectedThemes[i].id)
        }

        return arrayPush;
    }


    /*This function is under discussion*/

    /*addInExpertList(){
        let url = `backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/expert-in`;


        return this.http.post(url, JSON.stringify({
            theme_ids: this.getSelectedThemesIds()
        }));
    }


    createExpertList(){
        let url = `backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/expert-in`;


        return this.http.put(url, JSON.stringify({
            theme_ids: this.getSelectedThemesIds()
        }));
    }*/


    addInInterestList(){
        let url = `backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/interesting-in`;

        return this.http.post(url, JSON.stringify({
            theme_ids: this.getSelectedThemesIds()
        }));
    }

    createInterestList(){
        let url = `backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/interesting-in`;

        return this.http.put(url, JSON.stringify({
            theme_ids: this.getSelectedThemesIds()
        }));
    }


    avatarUpload() {
        this.tryNumber++;
        let url = `/backend/api/protected/profile/${AuthService.getAuthToken().getCurrentProfile().entity.id}/image-upload/crop-start/${this.crop.start.x}/${this.crop.start.y}/crop-end/${this.crop.end.x}/${this.crop.end.y}`;
        let formData = new FormData();
        formData.append("file", this.file);

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

export class ProfileInfo
{
    greetings_method: string;
    nickname: string;
    firstname: string;
    lastname: string;
    middlename: string;
    sex: string;
    birthday: string;
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