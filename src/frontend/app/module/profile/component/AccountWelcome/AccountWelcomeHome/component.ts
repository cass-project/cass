import {Component, Injectable} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {ProfileService} from "../../../service/ProfileService";
import {AvatarCropper} from "../../AvatarCropper/index";
import {CORE_DIRECTIVES} from "angular2/common";
import {AuthService} from "../../../../auth/service/AuthService";
import {AvatarCropperService} from "../../AvatarCropper/service";
import {AccountConfirm} from "../Confirm/component";
import {ProfileNameInfo} from "../../../service/ProfileService";

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
        CORE_DIRECTIVES,
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

    profileNameInfo: ProfileNameInfo = new ProfileNameInfo();
    isVisibleChooseType: boolean = true;

    ngOnInit() {
        if(this.profileService.checkInitProfile()){
            this.router.parent.navigate(['Dashboard']);
        } else {
            AuthService.getAuthToken().getCurrentProfile().entity.greetings.greetings_method = '';
            AuthService.getAuthToken().getCurrentProfile().entity.greetings.first_name = '';
            AuthService.getAuthToken().getCurrentProfile().entity.greetings.last_name = '';
            AuthService.getAuthToken().getCurrentProfile().entity.greetings.middle_name = '';
            AuthService.getAuthToken().getCurrentProfile().entity.greetings.nickname = '';
        }
    }


    greetingsMethodReturn(){
        return AuthService.getAuthToken().getCurrentProfile().entity.greetings.greetings_method;
    }

    greetingsMethod(greetingsAs){
        AuthService.getAuthToken().getCurrentProfile().entity.greetings.greetings_method = greetingsAs;
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
        AuthService.getAuthToken().getCurrentProfile().entity.greetings.greetings_method = '';
        AuthService.getAuthToken().getCurrentProfile().entity.greetings.first_name = '';
        AuthService.getAuthToken().getCurrentProfile().entity.greetings.last_name = '';
        AuthService.getAuthToken().getCurrentProfile().entity.greetings.middle_name = '';
        AuthService.getAuthToken().getCurrentProfile().entity.greetings.nickname = '';

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


    submit(){
        if (this.getGreetings()) {
            switch (AuthService.getAuthToken().getCurrentProfile().entity.greetings.greetings_method){
                case 'fl':
                    AuthService.getAuthToken().getCurrentProfile().entity.greetings.first_name = this.profileNameInfo.firstname;
                    AuthService.getAuthToken().getCurrentProfile().entity.greetings.last_name = this.profileNameInfo.lastname;
                    break;
                case 'flm':
                    AuthService.getAuthToken().getCurrentProfile().entity.greetings.first_name = this.profileNameInfo.firstname;
                    AuthService.getAuthToken().getCurrentProfile().entity.greetings.last_name = this.profileNameInfo.lastname;
                    AuthService.getAuthToken().getCurrentProfile().entity.greetings.middle_name = this.profileNameInfo.middlename;
                    break;
                case 'n':
                    AuthService.getAuthToken().getCurrentProfile().entity.greetings.nickname = this.profileNameInfo.nickname;
                    break;
            }
        }
        this.router.parent.navigate(['Confirm']);
    }
}
