import {Component} from "angular2/core";

import {ThemeSelect} from "../../../../../../theme/component/ThemeSelect";
import {CommunityService} from "../../../../../service/CommunityService";

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
    private isCommunitySettingsModalThemeEnablePublic: boolean;
    private isCommunitySettingsModalThemeWillModerate: boolean;

    constructor(public service: CommunityService) {}

    communitySettingsModalThemeEnabledChange($event: boolean) {
        if($event===false) {
            this.isCommunitySettingsModalThemeEnablePublic = false;
            this.isCommunitySettingsModalThemeWillModerate = false;
        }
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