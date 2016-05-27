import {Component} from "angular2/core";

import {ModalComponent} from "../../../modal/component/index";
import {ProfileSetupModel} from "./model";
import {LoadingLinearIndicator} from "../../../util/component/LoadingLinearIndicator/index";
import {ProfileSetupScreenGreetings} from "./Screen/ProfileSetupScreenGreetings/index";
import {ProfileSetupScreenGender} from "./Screen/ProfileSetupScreenGender/index";
import {ProfileSetupScreenImage} from "./Screen/ProfileSetupScreenImage/index";
import {ProfileSetupScreenInterests} from "./Screen/ProfileSetupScreenInterests/index";
import {ProfileSetupScreenExpertIn} from "./Screen/ProfileSetupScreenExpertIn/index";
import {ComponentStages} from "../../../util/classes/ComponentStages";
import {ScreenControls} from "../../../util/classes/ScreenControls";
import {ProfileRESTService} from "../ProfileService/ProfileRESTService";
import {FrontlineService} from "../../../frontline/service";
import {ProfileComponentService} from "../../service";


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
    public screens: ScreenControls<ProfileSetupScreen> = new ScreenControls<ProfileSetupScreen>(ProfileSetupScreen.Welcome, (sc: ScreenControls<ProfileSetupScreen>) => {
        sc.add({ from: ProfileSetupScreen.Welcome, to: ProfileSetupScreen.Gender })
          .add({ from: ProfileSetupScreen.Gender, to: ProfileSetupScreen.Greetings })
          .add({ from: ProfileSetupScreen.Greetings, to: ProfileSetupScreen.Image })
          .add({ from: ProfileSetupScreen.Image, to: ProfileSetupScreen.Interests })
          .add({ from: ProfileSetupScreen.Interests, to: ProfileSetupScreen.ExpertIn })
          .add({ from: ProfileSetupScreen.ExpertIn, to: ProfileSetupScreen.Saving })
          .add({ from: ProfileSetupScreen.Saving, to: ProfileSetupScreen.Finish });
    });

    constructor(public model: ProfileSetupModel, private frontlineService: FrontlineService,  private profileRESTService: ProfileRESTService, private modals: ProfileComponentService) {}

    changeGender(event){
        if (!~['male', 'female'].indexOf(event)) {
            throw new Error('MMM WHUT IS THIS U FILTHY CASUL?');
        }

        this.model.profile.gender.string = event;
        this.ngSubmit();
    }

    verifyStage() {
        /*if(this.frontlineService.session.auth.profiles[0].image.public_path !== '/public/assets/profile-default.png'){
         return true;
         }*/

        /*Greetings stage*/
        if (this.screens.isIn([ProfileSetupScreen.Greetings]) &&
            this.model.greetings.greetingsMethod !== '') {
            if (this.model.greetings.greetingsMethod === 'fl' &&
                this.model.greetings.first_name.length > 0 && this.model.greetings.last_name.length > 0) {
                return true;
            } else if (this.model.greetings.greetingsMethod === 'n' &&
                this.model.greetings.nickname.length > 0) {
                return true;
            } else if (this.model.greetings.greetingsMethod === 'fm' &&
                this.model.greetings.first_name.length > 0 && this.model.greetings.middle_name.length > 0) {
                return true;
            } else if (this.model.greetings.greetingsMethod === 'lfm' &&
                this.model.greetings.first_name.length > 0 && this.model.greetings.last_name.length > 0 && this.model.greetings.middle_name.length > 0) {
                return true;
            }
        }
        /*InterestsIn stage*/
        if (this.screens.isIn([ProfileSetupScreen.Interests]) &&
            (JSON.stringify(this.model.interestingIn) != JSON.stringify(this.frontlineService.session.auth.profiles[0].interesting_in))){
            return true
        }
        /*ExpertIn stage*/
         if (this.screens.isIn([ProfileSetupScreen.ExpertIn]) &&
             (JSON.stringify(this.model.expertIn) != JSON.stringify(this.frontlineService.session.auth.profiles[0].expert_in))){
            return true;
        }
    }


    SaveSetupChanges(){
        this.nextStage();
        this.profileRESTService.editSex(this.model.profile).subscribe(data => {
            this.profileRESTService.editPersonal(this.model.profile).subscribe(data => {
                this.profileRESTService.updateInterestThemes(this.model.interestingIn).subscribe(data => {
                    this.profileRESTService.updateExpertThemes(this.model.expertIn).subscribe(data => {
                        this.nextStage();
                    });
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
            ProfileSetupScreen.Image,
            ProfileSetupScreen.ExpertIn
        ]);
    }

    isSkipButtonVisible() {
        return this.screens.isIn([
            ProfileSetupScreen.Image,
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