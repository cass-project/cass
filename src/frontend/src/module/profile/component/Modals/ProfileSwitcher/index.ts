import {Component, Output, EventEmitter} from "angular2/core";

import {ProfileImage} from "../../Elements/ProfileImage/index";
import {ComponentStages} from "../../../../util/classes/ComponentStages";
import {ProfileSwitcherService} from "./service";
import {LoadingLinearIndicator} from "../../../../form/component/LoadingLinearIndicator/index";

enum ProfileSwitcherStage
{
    Choice = <any>"Choice",
    Processing = <any>"Processing"
}

@Component({
    selector: 'cass-profile-switcher',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileImage,
        LoadingLinearIndicator
    ]
})

export class ProfileSwitcher
{
    
    @Output('close') close = new EventEmitter<boolean>();
    stage: ComponentStages<ProfileSwitcherStage> = new ComponentStages<ProfileSwitcherStage>(ProfileSwitcherStage.Choice);

    constructor(private service: ProfileSwitcherService) {}

    closeProfileSwitcher() {
       this.close.emit(true); 
    }
}