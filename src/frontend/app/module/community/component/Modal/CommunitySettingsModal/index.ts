import {Component, EventEmitter, Output, Input} from "angular2/core";
import {Input} from "angular2/core";

import {ModalBoxComponent} from "../../../../modal/component/box/index";
import {ModalComponent} from "../../../../modal/component/index";
import {ScreenControls} from "../../../../util/classes/ScreenControls";

import {CommunityModel} from "../../../model";
import {CommunityService} from "../../../service/CommunityService";
import {CommunityFeaturesService} from "../../../service/CommunityFeaturesService";

import {FeaturesTab} from "./Tab/TabFeatures/index";
import {GeneralTab} from "./Tab/TabGeneral/index";
import {ImageTab} from "./Tab/TabImage/index";
import {CommunityResponseModel} from "../../../model";



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
        CommunityModel,
        CommunityResponseModel,
        CommunityFeaturesService
    ]
})

export class CommunitySettingsModal
{
    @Output('close') closeEvent = new EventEmitter<CommunitySettingsModal>();
    protected sid:string = "XtPvOgjf";

    constructor(protected responseModel: CommunityResponseModel, protected service: CommunityService) {
    }

    ngOnInit(){
        this.service.getBySid(this.sid).subscribe(
            data => {
                this.responseModel.entity = data.entity;
            }
        );
    }

    public screens: ScreenControls<SettingsStage> = new ScreenControls<SettingsStage>(SettingsStage.General);

    close() {
        this.closeEvent.emit(this);
    }

    canSave() {
        return true;
    }
}

enum SettingsStage {
    General = <any>"General",
    Features = <any>"Features",
    Image = <any>"Image"
}
