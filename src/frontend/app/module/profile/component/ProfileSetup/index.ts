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
        ProfileSetupModel
    ],
    directives: [
        ModalComponent,
        LoadingLinearIndicator,
        ProfileSetupScreenGreetings,
        ProfileSetupScreenGender,
        ProfileSetupScreenImage,
        ProfileSetupScreenInterests,
        ProfileSetupScreenExpertIn,
    ]
})

export class ProfileSetup
{
    public screens: ScreenControls<ProfileSetupScreen> = new ScreenControls<ProfileSetupScreen>(ProfileSetupScreen.Welcome);

    constructor(public model: ProfileSetupModel) {
        this.screens
            .add({ from: ProfileSetupScreen.Welcome, to: ProfileSetupScreen.Gender })
            .add({ from: ProfileSetupScreen.Gender, to: ProfileSetupScreen.Greetings })
            .add({ from: ProfileSetupScreen.Greetings, to: ProfileSetupScreen.Image })
            .add({ from: ProfileSetupScreen.Image, to: ProfileSetupScreen.Interests })
            .add({ from: ProfileSetupScreen.Interests, to: ProfileSetupScreen.ExpertIn })
            .add({ from: ProfileSetupScreen.ExpertIn, to: ProfileSetupScreen.Saving })
            .add({ from: ProfileSetupScreen.Saving, to: ProfileSetupScreen.Finish })
        ;
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
            ProfileSetupScreen.Greetings,
        ]);
    }

    isSubmitButtonVisible() {
        return this.screens.notIn([
            ProfileSetupScreen.Finish,
            ProfileSetupScreen.Gender,
        ]);
    }

    isSkipButtonVisible() {
        return this.screens.isIn([
            ProfileSetupScreen.Image,
            ProfileSetupScreen.Interests,
            ProfileSetupScreen.ExpertIn,
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