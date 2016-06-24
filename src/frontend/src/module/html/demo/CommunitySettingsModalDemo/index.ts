import {Component} from "angular2/core";
import {ScreenControls} from "../../../util/classes/ScreenControls";
import {ModalComponent} from "../../../modal/component/index";
import {ModalBoxComponent} from "../../../modal/component/box/index";
import {ThemeSelect} from "../../../theme/component/ThemeSelect/index";
import {CommunityImage} from "../../../community/component/Elements/CommunityImage/index";

enum CommunitySettingsScreen
{
    Community = <any>"Community",
    Image = <any>"Image",
    Features = <any>"Features",
    Collections = <any>"Collection"
}

enum DeleteRequestStage
{
    NoRequest,
    PendingConfirmation,
    Confirmed
}

let communitySettingsScreenMap = (sc: ScreenControls<CommunitySettingsScreen>) => {
    sc.add({ from:  CommunitySettingsScreen.Community, to: CommunitySettingsScreen.Image })
      .add({ from:  CommunitySettingsScreen.Image, to: CommunitySettingsScreen.Features })
      .add({ from:  CommunitySettingsScreen.Features, to: CommunitySettingsScreen.Collections })
      .add({ from:  CommunitySettingsScreen.Collections, to: CommunitySettingsScreen.Image })
};

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
        ThemeSelect,
        CommunityImage,
    ]
})
export class CommunitySettingsModalDemo
{
    private screens: ScreenControls<CommunitySettingsScreen> = new ScreenControls<CommunitySettingsScreen>(CommunitySettingsScreen.Image, communitySettingsScreenMap);
    private deleteRequest: CommunityDeleteRequestControls = new CommunityDeleteRequestControls();
}

class CommunityDeleteRequestControls
{
    private buttonDisabled: boolean = false;
    public stage: DeleteRequestStage = DeleteRequestStage.NoRequest;

    request() {
        this.buttonDisabled = true;

        setTimeout(() => {
            this.stage = DeleteRequestStage.PendingConfirmation;
            this.buttonDisabled = false;
        }, 1000);
    }

    confirm() {
        this.stage = DeleteRequestStage.Confirmed;
    }

    cancel() {
        this.stage = DeleteRequestStage.NoRequest;
    }

    isButtonDisabled() {
        return this.buttonDisabled;
    }

    isRequested() {
        return this.stage === DeleteRequestStage.PendingConfirmation;
    }

    isConfirmed() {
        return this.stage === DeleteRequestStage.Confirmed;
    }
}