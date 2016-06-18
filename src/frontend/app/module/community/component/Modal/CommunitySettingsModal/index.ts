import {Component, EventEmitter, Output} from "angular2/core";

import {ModalBoxComponent} from "../../../../modal/component/box";
import {ModalComponent} from "../../../../modal/component";
import {ScreenControls} from "../../../../util/classes/ScreenControls";

import {CommunityService} from "../../../service/CommunityService";
import {CommunityFeaturesService} from "../../../service/CommunityFeaturesService";

import {FeaturesTab} from "./Tab/TabFeatures";
import {GeneralTab} from "./Tab/TabGeneral";
import {ImageTab} from "./Tab/TabImage";
import {CommunityEnity} from "../../../enity/Community";
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
        CommunityEnity,
        CommunityFeaturesService
    ]
})

export class CommunitySettingsModal
{
    public screens: ScreenControls<SettingsStage> = new ScreenControls<SettingsStage>(SettingsStage.General);

    @Output('close') closeEvent = new EventEmitter<CommunitySettingsModal>();

    constructor(
        public model:CommunitySettingsModalModel,
        public modelUnmodified:CommunitySettingsModalModel,
        private service: CommunityService
    ) {
        service.getBySid(model.sid).subscribe(data => {
            model.title = data.entity.title;
            model.description = data.entity.description;
            model.theme_id = data.entity.theme_id;
            model.image.public_path = data.entity.image.public_path;
            modelUnmodified = model;
        });
    }

    reset() {
        this.model = JSON.parse(JSON.stringify(this.modelUnmodified));
    }


    close() {
        this.closeEvent.emit(this);
    }

    canSave() {
        return JSON.stringify( this.modelUnmodified ) !== JSON.stringify(this.model)
    }

    saveAllChanges() {
        console.log(this.service.community);
    }
}

enum SettingsStage {
    General = <any>"General",
    Features = <any>"Features",
    Image = <any>"Image"
}
