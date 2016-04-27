import {Component, Injectable} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {ProfileService} from "../../service/ProfileService";
import {AvatarCropper} from "../AvatarCropper/index";
import {CORE_DIRECTIVES} from "angular2/common";
import {AuthService} from "../../../auth/service/AuthService";
import {AvatarCropperService} from "../AvatarCropper/service";
import {ProfileInfo} from "../../service/ProfileService";
import {ThemeSelector} from "../../../theme/component/ThemeSelector/component";

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
        ThemeSelector,
        AvatarCropper
    ]
})


@Injectable()
export class ProfileEdit {
    constructor(private profileService: ProfileService,
                public router: Router,
                public avatarCropperService: AvatarCropperService) {
        this.getCurrentProfileInfo();
    }

    profileInfo: ProfileInfo = new ProfileInfo();

    greetingsMethodReturn(){
            return this.profileInfo.greetings_method;
    }

    getGreetingsMethod() {
        return this.profileInfo.greetings_method;
    }

    setGreetingsMethod(greetingAS){
        this.profileInfo.greetings_method = greetingAS;
    }

    getCurrentProfileInfo(){
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;

        this.profileInfo.greetings_method = greetings.greetings_method;
        this.profileInfo.firstname = greetings.first_name;
        this.profileInfo.lastname = greetings.last_name;
        this.profileInfo.middlename = greetings.middle_name;
        this.profileInfo.nickname = greetings.nickname;
    }

    submit() {
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;
        greetings.greetings_method = this.profileInfo.greetings_method;

        if (AuthService.getGreetings()) {
            switch (greetings.greetings_method){
                case 'fl':
                    greetings.first_name = this.profileInfo.firstname;
                    greetings.last_name = this.profileInfo.lastname;
                    this.profileService.greetingsAsFL().subscribe(data => {
                        this.router.parent.navigate(['Dashboard']);
                    });
                    break;
                case 'flm':
                    greetings.first_name = this.profileInfo.firstname;
                    greetings.last_name = this.profileInfo.lastname;
                    greetings.middle_name = this.profileInfo.middlename;
                    this.profileService.greetingsAsFLM().subscribe(data => {
                        this.router.parent.navigate(['Dashboard']);
                    });
                    break;
                case 'n':
                    greetings.nickname = this.profileInfo.nickname;
                    this.profileService.greetingsAsN().subscribe(data => {
                        this.router.parent.navigate(['Dashboard']);
                    });
                    break;
            }
        }
    }
}

