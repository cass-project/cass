var xmlRequest = new XMLHttpRequest();

import {Injectable} from 'angular2/core';
import {Http, URLSearchParams} from 'angular2/http';
import {AuthService} from "../../../auth/service/AuthService";
import {AvatarCropperService} from "../../../util/component/AvatarCropper/service";
import {ProfileModalModel} from "../ProfileModal/model";
import {FrontlineService} from "../../../frontline/service";
import {ThemeService} from "../../../theme/service/ThemeService";

@Injectable()
export class ProfileRESTService
{
    constructor(public http: Http, private avatarCropperService: AvatarCropperService, private frontlineService: FrontlineService, private themeService: ThemeService){}

    public tryNumber: number = 0;
    public progressBar: number;
    public changePasswordStn = {old_password: '', new_password: '', repeat_password: ''};


    accountCondReset(){
        this.changePasswordStn.old_password = '';
        this.changePasswordStn.new_password = '';
        this.changePasswordStn.repeat_password = '';
    }

    accountCondToSave(){
        if(this.changePasswordStn.new_password.length > 0 &&
            this.changePasswordStn.repeat_password.length > 0 &&
            this.changePasswordStn.new_password === this.changePasswordStn.repeat_password &&
            this.changePasswordStn.new_password !== this.changePasswordStn.old_password){
            return true;
        } else if(this.changePasswordStn.new_password.length > 0 &&
            this.changePasswordStn.repeat_password.length > 0 &&
            this.changePasswordStn.new_password === this.changePasswordStn.old_password &&
            this.changePasswordStn.repeat_password === this.changePasswordStn.old_password){
            console.log("Старый и новые пароли совпадают");
        }
    }

    /*interestCondReset(){
        this.themeService.pickedInterestingInThemes = this.frontlineService.session.auth.profiles[0].interesting_in;
        this.themeService.pickedExpertInThemes = this.frontlineService.session.auth.profiles[0].expert_in;
    }

    interestCondToSave(){
        console.log(this.frontlineService.session.auth.profiles[0].interesting_in, this.themeService.pickedInterestingInThemes);
        if(this.frontlineService.session.auth.profiles[0].interesting_in != this.themeService.pickedInterestingInThemes ||
            this.frontlineService.session.auth.profiles[0].expert_in != this.themeService.pickedExpertInThemes){
            return true;
        }
    }*/

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
            old_password: this.changePasswordStn.old_password,
            new_password: this.changePasswordStn.new_password
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