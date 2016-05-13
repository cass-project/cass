import {Component} from "angular2/core";

import {ModalComponent} from "../../../modal/component/index";
import {ProfileSettingsGreetings} from "../ProfileSettings/ProfileSettingsGreetings/index";
import {ProfileSettingsImage} from "../ProfileSettings/ProfileSettingsImage/index";
import {ProfileSettingsInterests} from "../ProfileSettings/ProfileSettingsInterests/index";
import {ProfileSettingsExpertIn} from "../ProfileSettings/ProfileSettingsExpertIn/index";
import {ProfileSetupModel} from "./model";

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
        ProfileSettingsGreetings,
        ProfileSettingsImage,
        ProfileSettingsInterests,
        ProfileSettingsExpertIn,
    ]
})
export class ProfileSetup
{
    stage: StageControls = new StageControls();

    constructor(model: ProfileSetupModel) {}

    ngSubmit() {
        this.nextStage();
    }

    nextStage() {
        this.stage.next();
    }

    prevStage() {
        this.stage.previous();
    }

    isPreviousButtonVisible() {
        return ! (this.stage.isOnFinishStage() || this.stage.isOnWelcomeStage() || this.stage.isOnGreetingsStage());
    }

    isSubmitButtonVisible() {
        return ! this.stage.isOnFinishStage();
    }

    isSkipButtonVisible() {
        return this.stage.isOnImageStage() || this.stage.isOnInterestsStage();
    }

    isFooterVisible() {
        return ! (this.stage.isOnWelcomeStage() || this.stage.isOnFinishStage());
    }
}

class StageControls
{
    private stage: ProfileSetupStage = ProfileSetupStage.StageWelcome;
    private map = (() => {
        let map = {};

        map[ProfileSetupStage.StageWelcome] = ProfileSetupStage.StageGreetings;
        map[ProfileSetupStage.StageGreetings] = ProfileSetupStage.StageImage;
        map[ProfileSetupStage.StageImage] = ProfileSetupStage.StageInterests;
        map[ProfileSetupStage.StageInterests] = ProfileSetupStage.StageFinish;

        return map;
    })();

    go(stage: ProfileSetupStage) {
        this.stage = stage;
    }

    next() {
        if(this.map[this.stage]) {
            this.stage = this.map[this.stage];
        }else{
            throw new Error('Nowhere to go.');
        }
    }

    previous() {
        throw new Error('Not implemented');
    }

    isOnWelcomeStage() {
        return this.stage === ProfileSetupStage.StageWelcome;
    }

    isOnGreetingsStage() {
        return this.stage === ProfileSetupStage.StageGreetings;
    }

    isOnImageStage() {
        return this.stage === ProfileSetupStage.StageImage;
    }

    isOnInterestsStage() {
        return this.stage === ProfileSetupStage.StageInterests;
    }

    isOnFinishStage() {
        return this.stage === ProfileSetupStage.StageFinish;
    }
}

enum ProfileSetupStage {
    StageWelcome,
    StageGreetings,
    StageImage,
    StageInterests,
    StageFinish
}