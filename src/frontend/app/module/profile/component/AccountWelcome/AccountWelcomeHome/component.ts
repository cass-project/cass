import {Component, Injectable} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {ProfileService} from "../../../service/ProfileService";
import {AvatarCropper} from "../../AvatarCropper/index";
import {AuthService} from "../../../../auth/service/AuthService";
import {AvatarCropperService} from "../../AvatarCropper/service";
import {AccountConfirm} from "../Confirm/component";
import {ProfileInfo} from "../../../service/ProfileService";

declare var Cropper;

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss'),
    ],
    'providers': [
        ProfileService,
        AvatarCropperService,
        AccountConfirm
    ],
    directives: [
        ROUTER_DIRECTIVES,
        AvatarCropper
    ]
})


@Injectable()
export class AccountWelcomeHome {
    constructor (private profileService: ProfileService,
                 public router: Router,
                 public avatarCropperService: AvatarCropperService,
                 public accountConfirm: AccountConfirm
    ){}

    profileInfo: ProfileInfo = new ProfileInfo();
    isVisibleChooseType: boolean = true;

    ngOnInit() {
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;

        if(ProfileService.checkInitProfile()){
            this.router.parent.navigate(['Dashboard']);
        } else {
            greetings.greetings_method = '';
            greetings.first_name = '';
            greetings.last_name = '';
            greetings.middle_name = '';
            greetings.nickname = '';
        }
    }

    greetingsMethodReturn(){
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;

        return greetings.greetings_method;
    }

    greetingsMethod(greetingsAs){
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;

        greetings.greetings_method = greetingsAs;
        this.showNextStage();
    }

    stageButtons: any = {
        nextShowButton: false
    };

    showNextStage(){
        this.isVisibleChooseType = false;
        this.stageButtons.nextShowButton = true;
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


    submit(){
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;

        if (AuthService.getGreetings()) {
            switch (greetings.greetings_method){
                case 'fl':
                    greetings.first_name = this.profileInfo.firstname;
                    greetings.last_name = this.profileInfo.lastname;
                    break;
                case 'flm':
                    greetings.first_name = this.profileInfo.firstname;
                    greetings.last_name = this.profileInfo.lastname;
                    greetings.middle_name = this.profileInfo.middlename;
                    break;
                case 'n':
                    greetings.nickname = this.profileInfo.nickname;
                    break;
            }
        }
        this.router.parent.navigate(['Confirm']);
    }
}
