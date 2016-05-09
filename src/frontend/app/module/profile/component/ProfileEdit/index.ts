import {Component, Injectable} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {ProfileService} from "../../service/ProfileService";
import {AvatarCropper} from "../AvatarCropper/index";
import {CORE_DIRECTIVES} from "angular2/common";
import {AuthService} from "../../../auth/service/AuthService";
import {AvatarCropperService} from "../AvatarCropper/service";
import {ProfileInfo} from "../../service/ProfileService";
import {ThemeSelector} from "../../../theme/component/ThemeSelector/component";
import {ThemeService} from "../../../theme/service/ThemeService";

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
                public avatarCropperService: AvatarCropperService,
                public themeService: ThemeService
    ) {
        this.getCurrentProfileInfo();
    }

    getGreetingsMethod() {
        return this.profileService.profileInfo.greetings_method;
    }

    setGreetingsMethod(greetingAS){
        this.profileService.profileInfo.greetings_method = greetingAS;
    }

    getCurrentProfileInfo(){
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;

        this.profileService.profileInfo.greetings_method = greetings.greetings_method;
        this.profileService.profileInfo.firstname = greetings.first_name;
        this.profileService.profileInfo.lastname = greetings.last_name;
        this.profileService.profileInfo.middlename = greetings.middle_name;
        this.profileService.profileInfo.nickname = greetings.nickname;
    }

    showAvatarCropper() {
        this.avatarCropperService.isAvatarFormVisibleFlag = true;
    }

    isAvatarFormVisible() {
        return this.avatarCropperService.isAvatarFormVisibleFlag;
    }


    submit() {
        let profileInfo;
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;
        greetings.greetings_method = this.profileService.profileInfo.greetings_method;


        this.profileService.getProfileInfo().subscribe(data => {
            profileInfo = data;
            /*if(profileInfo.entity.expert_in.length > 0) {
                this.profileService.createExpertList().subscribe(data => {console.log(data)}, err => {console.log(err)});
            } else {
                this.profileService.addInExpertList().subscribe(data => {console.log(data)}, err => {console.log(err)});
            }*/

            if(profileInfo.entity.interesting_in.length > 0){
                this.profileService.createInterestList().subscribe(data => {console.log(data)}, err => {console.log(err)});
            } else {
                this.profileService.addInInterestList().subscribe(data => {console.log(data)}, err => {console.log(err)});
            }
        });

        if (AuthService.getGreetings()) {
            switch (greetings.greetings_method){
                case 'fl':
                    greetings.first_name = this.profileService.profileInfo.firstname;
                    greetings.last_name = this.profileService.profileInfo.lastname;
                    this.profileService.greetingsAsFL().subscribe(data => {
                        this.router.parent.navigate(['Dashboard']);
                    });
                    break;
                case 'flm':
                    greetings.first_name = this.profileService.profileInfo.firstname;
                    greetings.last_name = this.profileService.profileInfo.lastname;
                    greetings.middle_name = this.profileService.profileInfo.middlename;
                    this.profileService.greetingsAsFLM().subscribe(data => {
                        this.router.parent.navigate(['Dashboard']);
                    });
                    break;
                case 'n':
                    greetings.nickname = this.profileService.profileInfo.nickname;
                    this.profileService.greetingsAsN().subscribe(data => {
                        this.router.parent.navigate(['Dashboard']);
                    });
                    break;
            }
        }
    }
}

