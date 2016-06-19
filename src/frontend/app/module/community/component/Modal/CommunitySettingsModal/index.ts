import {Component, EventEmitter, Output} from "angular2/core";

import {ModalBoxComponent} from "../../../../modal/component/box";
import {ModalComponent} from "../../../../modal/component";
import {ScreenControls} from "../../../../util/classes/ScreenControls";

import {CommunityService} from "../../../service/CommunityService";
import {CommunityFeaturesService} from "../../../service/CommunityFeaturesService";

import {FeaturesTab} from "./Tab/TabFeatures";
import {GeneralTab} from "./Tab/TabGeneral";
import {ImageTab} from "./Tab/TabImage";
import {CommunitySettingsModalModel} from "./model";



@Component({
    selector: 'cass-community-settings-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
        GeneralTab,
        ImageTab,
        FeaturesTab
    ],
    providers: [
        CommunityFeaturesService
    ]
})

export class CommunitySettingsModal
{
    public screens: ScreenControls<SettingsStage> = new ScreenControls<SettingsStage>(SettingsStage.General);
    public modelUnmodified:CommunitySettingsModalModel;

    @Output('close') closeEvent = new EventEmitter<CommunitySettingsModal>();

    constructor(
        public model:CommunitySettingsModalModel,
        private service: CommunityService
    ) {
        service.getBySid(model.sid).subscribe(data => {
            model.title = data.entity.title;
            model.description = data.entity.description;
            model.theme_id = data.entity.theme_id;
            model.public_options = {
                moderation_contract: false, //data.entity.public_options.moderation_contract;
                public_enabled: false //data.entity.public_options.public_enabled;
            };
            this.modelUnmodified = JSON.parse(JSON.stringify(model));
        });
    }

    reset() {
        this.model.title = this.modelUnmodified.title;
        this.model.description = this.modelUnmodified.description;
        this.model.theme_id = this.modelUnmodified.theme_id;
    }

    close() {
        this.closeEvent.emit(this);
    }

    canSave() {
        return JSON.stringify( this.modelUnmodified ) !== JSON.stringify(this.model)
    }

    saveAllChanges() {
        console.log(this.model);
    }
}

enum SettingsStage {
    General = <any>"General",
    Features = <any>"Features",
    Image = <any>"Image"
}
