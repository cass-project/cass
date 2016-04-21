import {Component, Injectable} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {ProfileService} from "../../service/ProfileService";
import {AvatarCropper} from "../AvatarCropper/index";
import {CORE_DIRECTIVES} from "angular2/common";
import {AuthService} from "../../../auth/service/AuthService";
import {Profile} from "../../entity/Profile";
import {AvatarCropperService} from "../AvatarCropper/service";
import {ProfileInfo} from "../../service/ProfileService";

declare var Cropper;

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss'),
    ],
    'providers': [
        ProfileService,
        AvatarCropperService
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CORE_DIRECTIVES,
        AvatarCropper
    ]
})


@Injectable()
export class ProfileEdit {
    constructor(private profileService: ProfileService,
                public router: Router,
                public avatarCropperService: AvatarCropperService) {
    }

    showEdit: boolean = false;
    isVisibleChooseType: boolean = true;
    profileInfo: ProfileInfo = new ProfileInfo();

    ngOnInit():void {
        this.getProfileAvatar();
        this.getCurrentProfileInfo();
    }

    greetingsMethodReturn(){
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;
        if(!this.isVisibleChooseType) {
            return greetings.greetings_method;
        }
    }

    greetingsMethod(greetingsAs){
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;

        greetings.greetings_method = greetingsAs;
    }

    showAvatarCropper() {
        this.avatarCropperService.isAvatarFormVisibleFlag = true;
    }

    isAvatarFormVisible() {
        return this.avatarCropperService.isAvatarFormVisibleFlag;
    }

    isSignedIn() {
        return AuthService.isSignedIn();
    }

    getGreetings() {
        return this.isSignedIn()
            ? AuthService.getAuthToken().getCurrentProfile().greetings
            : 'Anonymous'
    }

    getCurrentProfileInfo(){
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;

        this.profileInfo.firstname = greetings.first_name;
        this.profileInfo.lastname = greetings.last_name;
        this.profileInfo.middlename = greetings.middle_name;
        this.profileInfo.nickname = greetings.nickname;
        //this.profileInfo.birthday = greetings.birthday;
        this.profileInfo.sex = "Male";
    }

    getProfileAvatar() {
        return this.isSignedIn()
            ? AuthService.getAuthToken().getCurrentProfile().entity.image.public_path
            : Profile.AVATAR_DEFAULT;
    }

    reset(){
        this.router.parent.navigate(['Dashboard']);
        this.router.parent.navigate(['Edit']);
    }

    submit() {
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;

        if (this.getGreetings()) {
            switch (greetings.greetings_method){
                case 'fl':
                    this.profileService.greetingsAsFL().subscribe(data => {
                        this.router.parent.navigate(['Dashboard']);
                        AuthService.getAuthToken().getCurrentProfile().entity.is_initialized = true;
                    });
                    break;
                case 'flm':
                    this.profileService.greetingsAsFLM().subscribe(data => {
                        this.router.parent.navigate(['Dashboard']);
                        AuthService.getAuthToken().getCurrentProfile().entity.is_initialized = true;
                    });
                    break;
                case 'n':
                    this.profileService.greetingsAsN().subscribe(data => {
                        this.router.parent.navigate(['Dashboard']);
                        AuthService.getAuthToken().getCurrentProfile().entity.is_initialized = true;
                    });
                    break;
            }
        }


    }
}

