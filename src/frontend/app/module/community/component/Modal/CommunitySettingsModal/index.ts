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
    public screens: ScreenControls<SettingsStage> = new ScreenControls<SettingsStage>(SettingsStage.Image);
    public modelUnmodified:CommunitySettingsModalModel;

    @Output('close') closeEvent = new EventEmitter<CommunitySettingsModal>();


    constructor(
        public model:CommunitySettingsModalModel,
        private service: CommunityService,
        private featuresService: CommunityFeaturesService
    ) {
        service.getBySid(model.sid).subscribe(data => {
            model.title = data.entity.title;
            model.description = data.entity.description;
            model.theme_id = data.entity.theme.id;
            model.public_options = {
                moderation_contract: data.entity.public_options.moderation_contract,
                public_enabled: data.entity.public_options.public_enabled
            };
            model.image = data.entity.image;
            
            this.model.features = [];
            for(let feature of featuresService.getFeatures()) {
                this.model.features.push({
                    "code": feature.code,
                    "is_activated": false,
                    "disabled": featuresService.isDisabled(feature.code)
                });
            }

            this.modelUnmodified = JSON.parse(JSON.stringify(model));
        });
    }

    reset() {
        for(let property in this.model){
            if(this.model.hasOwnProperty(property)){
                if(this.modelUnmodified.hasOwnProperty(property))
                    this.model[property] =  this.modelUnmodified[property];
                else delete this.model[property];
            }
        }
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
