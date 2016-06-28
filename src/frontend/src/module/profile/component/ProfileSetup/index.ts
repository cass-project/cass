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

    constructor(
        public model: ProfileSetupModel, 
        private profileRESTService: ProfileRESTService,
        private authService: AuthService
    ) {}

    close() {
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