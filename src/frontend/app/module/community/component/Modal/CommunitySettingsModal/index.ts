import {Component} from "angular2/core";
import {EventEmitter} from "angular2/core";

import {FeaturesTab} from "./Tab/TabFeatures/index";
import {GeneralTab} from "./Tab/TabGeneral/index";
import {ImageTab} from "./Tab/TabImage/index";
import {ModalBoxComponent} from "../../../../modal/component/box/index";
import {ModalComponent} from "../../../../modal/component/index";
import {CommunityCreateModalModel} from "../CommunityCreateModal/model";
import {CommunityFeaturesService} from "../../../service/CommunityFeaturesService";
import {Output} from "angular2/core";
import {ScreenControls} from "../../../../util/classes/ScreenControls";


enum SettingsStage {
    General = <any>"General",
    Features = <any>"Features",
    Image = <any>"Image"
}

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
        CommunityCreateModalModel,
        CommunityFeaturesService
    ]
})

export class CommunitySettingsModal
{
    @Output('close') closeEvent = new EventEmitter<CommunitySettingsModal>();

    public screens: ScreenControls<SettingsStage> = new ScreenControls<SettingsStage>(SettingsStage.Features);


    close() {
        this.closeEvent.emit(this);
    }

    canSave(){
        return true;
    }
}