import {Component, Injectable} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {ProfileService} from "../../../service/ProfileService";
import {AvatarCropper} from "../../AvatarCropper/index";
import {AuthService} from "../../../../auth/service/AuthService";
import {Profile} from "../../../entity/Profile";
import {AvatarCropperService} from "../../AvatarCropper/service";
import {AccountWelcomeHome} from "../AccountWelcomeHome/component";

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
        AvatarCropper
    ]
})


@Injectable()
export class AccountConfirm {
    constructor(private profileService: ProfileService,
                public router: Router,
                public avatarCropperService: AvatarCropperService) {
    }


    ngOnInit():void {
        this.getProfileAvatar();
        if (this.profileService.checkInitProfile()) {
            this.router.parent.navigate(['Dashboard']);
        }
    }

    showAvatarCropper() {
        this.avatarCropperService.isAvatarFormVisibleFlag = true;
    }

    isAvatarFormVisible() {
        return this.avatarCropperService.isAvatarFormVisibleFlag;
    }

    reset(){
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;

        greetings.greetings_method = '';
        greetings.first_name = '';
        greetings.last_name = '';
        greetings.middle_name = '';
        greetings.nickname = '';

        this.router.parent.navigate(['Dashboard']);
        this.router.parent.navigate(['Welcome']);
    }

    isSignedIn() {
        return AuthService.isSignedIn();
    }

    getGreetings() {
        return this.isSignedIn()
            ? AuthService.getAuthToken().getCurrentProfile().greetings
            : 'Anonymous'
    }

    getProfileName() {
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;

        if (this.getGreetings()) {
            switch (greetings.greetings_method) {
                case 'fl':
                    return `${greetings.first_name} ${greetings.last_name}`;
                    break;
                case 'flm':
                    return `${greetings.first_name} ${greetings.last_name} ${greetings.middle_name}`;
                    break;
                case 'n':
                    return `${greetings.nickname}`;
                    break;
            }
        }
    }

    getProfileAvatar() {
        return this.isSignedIn()
            ? AuthService.getAuthToken().getCurrentProfile().entity.image.public_path
            : Profile.AVATAR_DEFAULT;
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

