import {Component} from "angular2/core";

import {ThemeSelect} from "../../../../../../theme/component/ThemeSelect";
import {CommunitySettingsModalModel} from "../../model";

@Component({
    selector: 'cass-community-settings-modal-tab-general',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives:[
        ThemeSelect
    ]
})

export class GeneralTab {

    private deleteRequest: CommunityDeleteRequestControls = new CommunityDeleteRequestControls();
    private isCommunitySettingsModalThemeEnabled: boolean;

    constructor(public model: CommunitySettingsModalModel) {
        this.isCommunitySettingsModalThemeEnabled = !!model.theme_id;
    }

    communitySettingsModalThemeEnabledChange($event: boolean) {
        if($event===false) {
            this.model.public_options.public_enabled = false;
            this.model.public_options.moderation_contract = false;
        }
    }

    communitySettingsModalThemeEnablePublicChange($event: boolean) {
        if($event===false) {
            this.model.public_options.moderation_contract = false;
        }
    }

    updateThemeId(themeIds: number[]){
        this.model.theme_id = themeIds[0];

    }
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

enum DeleteRequestStage
{
    NoRequest,
    PendingConfirmation,
    Confirmed
}