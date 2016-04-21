import {Component, Injectable} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {ProfileService} from "../../../service/ProfileService";
import {AvatarCropper} from "../../AvatarCropper/index";
import {CORE_DIRECTIVES} from "angular2/common";
import {AuthService} from "../../../../auth/service/AuthService";
import {ProfileNameInfo} from "../../../service/ProfileService";
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
        CORE_DIRECTIVES,
        AvatarCropper
    ]
})


@Injectable()
export class AccountConfirm {
    constructor(private profileService:ProfileService,
                public router:Router,
                public avatarCropperService:AvatarCropperService,
                public accountWelcomeHome:AccountWelcomeHome) {
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

    reset() {
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
        if (this.getGreetings()) {
            switch (AuthService.getAuthToken().getCurrentProfile().entity.greetings.greetings_method) {
                case 'fl':
                    return `${AuthService.getAuthToken().getCurrentProfile().entity.greetings.first_name} ${AuthService.getAuthToken().getCurrentProfile().entity.greetings.last_name}`;
                    break;
                case 'flm':
                    return `${AuthService.getAuthToken().getCurrentProfile().entity.greetings.first_name} ${AuthService.getAuthToken().getCurrentProfile().entity.greetings.last_name} ${AuthService.getAuthToken().getCurrentProfile().entity.greetings.middle_name}`;
                    break;
                case 'n':
                    return `${AuthService.getAuthToken().getCurrentProfile().entity.greetings.nickname}`;
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
        if (this.accountWelcomeHome.chooseNameType.chooseFL) {
            this.profileService.greetingsAsFL(this.accountWelcomeHome.profileNameInfo.firstname, this.accountWelcomeHome.profileNameInfo.lastname).subscribe(data => {
                AuthService.getAuthToken().getCurrentProfile().entity.greetings.greetings_method = 'fl';
            });
        } else if (this.accountWelcomeHome.chooseNameType.chooseFLM) {
            this.profileService.greetingsAsFLM(this.accountWelcomeHome.profileNameInfo.firstname, this.accountWelcomeHome.profileNameInfo.lastname, this.accountWelcomeHome.profileNameInfo.middlename).subscribe(data => {
            });
        } else if (this.accountWelcomeHome.chooseNameType.chooseN) {
            this.profileService.greetingsAsN(this.accountWelcomeHome.profileNameInfo.nickname).subscribe(data => {
            });

            this.router.parent.navigate(['Dashboard']);
            //AuthService.getAuthToken().getCurrentProfile().entity.is_initialized = true;
        }
    }
}

