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
    protected sid:string = "e4juVgpP";
    private community: CommunityEnity;
    constructor(public service: CommunityService) {
        service.getBySid(this.sid).subscribe(data => {
            this.community = data.entity;
        });
    }

    reset() {
        this.service.community = JSON.parse(JSON.stringify(this.community))
    }


    close() {
        this.closeEvent.emit(this);
    }

    canSave() {
        return JSON.stringify( this.service.community ) !== JSON.stringify( this.community )
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
