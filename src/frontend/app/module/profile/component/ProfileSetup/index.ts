import {Component, Input} from "angular2/core";

import {ModalComponent} from "../../../modal/component/index";
import {ProfileSetupModel} from "./model";
import {ProfileSetupScreenGreetings} from "./Screen/ProfileSetupScreenGreetings/index";
import {ProfileSetupScreenGender} from "./Screen/ProfileSetupScreenGender/index";
import {ProfileSetupScreenImage} from "./Screen/ProfileSetupScreenImage/index";
import {ProfileSetupScreenInterests} from "./Screen/ProfileSetupScreenInterests/index";
import {ProfileSetupScreenExpertIn} from "./Screen/ProfileSetupScreenExpertIn/index";
import {ScreenControls} from "../../../util/classes/ScreenControls";
import {ProfileRESTService} from "../../service/ProfileRESTService";
import {ProfileComponentService} from "../../service";
import {AuthService} from "../../../auth/service/AuthService";
import {ModalBoxComponent} from "../../../modal/component/box/index";
import {LoadingLinearIndicator} from "../../../form/component/LoadingLinearIndicator/index";

enum ProfileSetupScreen {
    Welcome = <any>"Welcome",
    Gender = <any>"Gender",
    Greetings = <any>"Greetings",
    Image = <any>"Image",
    Interests = <any>"Interests",
    ExpertIn = <any>"ExpertIn",
    Saving = <any>"Saving",
    Finish = <any>"Finish"
}

@Component({
    selector: 'cass-profile-setup',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ProfileSetupModel,
        ProfileRESTService
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
        LoadingLinearIndicator,
        ProfileSetupScreenGreetings,
        ProfileSetupScreenGender,
        ProfileSetupScreenImage,
        ProfileSetupScreenInterests,
        ProfileSetupScreenExpertIn
    ]
})

export class ProfileSetup
{
    @Input('profile') profile;

    public screens: ScreenControls<ProfileSetupScreen> = new ScreenControls<ProfileSetupScreen>(ProfileSetupScreen.Welcome, (sc: ScreenControls<ProfileSetupScreen>) => {
        sc.add({ from: ProfileSetupScreen.Welcome, to: ProfileSetupScreen.Gender })
          .add({ from: ProfileSetupScreen.Gender, to: ProfileSetupScreen.Greetings })
          .add({ from: ProfileSetupScreen.Greetings, to: ProfileSetupScreen.Image })
          .add({ from: ProfileSetupScreen.Image, to: ProfileSetupScreen.Interests })
          .add({ from: ProfileSetupScreen.Interests, to: ProfileSetupScreen.ExpertIn })
          .add({ from: ProfileSetupScreen.ExpertIn, to: ProfileSetupScreen.Saving })
          .add({ from: ProfileSetupScreen.Saving, to: ProfileSetupScreen.Finish });
    });

    constructor(public model: ProfileSetupModel, private profileRESTService: ProfileRESTService, private modals: ProfileComponentService) {}

    changeGender(event){
        if (!~['male', 'female'].indexOf(event)) {
            throw new Error('MMM WHUT IS THIS U FILTHY CASUL?');
        }

        this.model.gender = event;
        this.ngSubmit();
    }

    verifyStage() {

        /*Greetings stage*/
        if (this.screens.isIn([ProfileSetupScreen.Greetings]) &&
            this.model.greetings.greetings_method !== '') {
            if (this.model.greetings.greetings_method === 'fl' &&
                this.model.greetings.first_name.length > 0 && this.model.greetings.last_name.length > 0) {
                return true;
            } else if (this.model.greetings.greetings_method === 'n' &&
                this.model.greetings.nickname.length > 0) {
                return true;
            } else if (this.model.greetings.greetings_method === 'fm' &&
                this.model.greetings.first_name.length > 0 && this.model.greetings.middle_name.length > 0) {
                return true;
            } else if (this.model.greetings.greetings_method === 'lfm' &&
                this.model.greetings.first_name.length > 0 && this.model.greetings.last_name.length > 0 && this.model.greetings.middle_name.length > 0) {
                return true;
            }
        }
        /*InterestsIn stage*/
        if (this.screens.isIn([ProfileSetupScreen.Interests]) &&
            (JSON.stringify(this.model.interestingIn) != JSON.stringify(AuthService.getAuthToken().getCurrentProfile().entity.profile.interesting_in_ids))){
            return true
        }
        /*ExpertIn stage*/
         if (this.screens.isIn([ProfileSetupScreen.ExpertIn]) &&
             (JSON.stringify(this.model.expertIn) != JSON.stringify(AuthService.getAuthToken().getCurrentProfile().entity.profile.expert_in_ids))){
            return true;
        }

        if(this.screens.isIn([ProfileSetupScreen.Image])){
            return true;
        }
    }


    SaveSetupChanges(){
        this.profile.interesting_in = this.model.interestingIn;
        this.profile.expert_in = this.model.expertIn;
        this.profile.greetings = JSON.parse(JSON.stringify(this.model.greetings));
        this.profile.gender = this.model.gender;

        this.nextStage();
            this.profileRESTService.editPersonal(this.profile).subscribe(data => {
                this.profileRESTService.updateInterestThemes(this.profile.interesting_in).subscribe(data => {
                    this.profileRESTService.updateExpertThemes(this.profile.expert_in).subscribe(data => {
                        this.nextStage();
                    });
                });
            });
    }

    close(){
        this.modals.modals.setup.close();
    }

    ngSubmit() {
        this.nextStage();
    }

    nextStage() {
        this.screens.next();
    }

    prevStage() {
        this.screens.previous();
    }

    isPreviousButtonVisible() {
        return this.screens.notIn([
            ProfileSetupScreen.Finish,
            ProfileSetupScreen.Welcome,
            ProfileSetupScreen.Gender
        ]);
    }

    isSubmitButtonVisible() {
        return this.screens.notIn([
            ProfileSetupScreen.Finish,
            ProfileSetupScreen.Gender,
            ProfileSetupScreen.ExpertIn
        ]);
    }

    isSkipButtonVisible() {
        return this.screens.isIn([
            ProfileSetupScreen.Interests,
            ProfileSetupScreen.Gender
        ]);
    }

    isFooterVisible() {
        return this.screens.notIn([
            ProfileSetupScreen.Welcome,
            ProfileSetupScreen.Saving,
            ProfileSetupScreen.Finish,
        ]);
    }
}