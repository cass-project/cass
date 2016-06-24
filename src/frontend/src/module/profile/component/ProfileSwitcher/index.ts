import {Component} from "angular2/core";

import {ProfileImage} from "../ProfileImage/index";
import {ComponentStages} from "../../../util/classes/ComponentStages";
import {ProfileComponentService} from "../../service";
import {ProfileSwitcherService} from "./service";
import {LoadingLinearIndicator} from "../../../form/component/LoadingLinearIndicator/index";

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
    stage: ComponentStages<ProfileSwitcherStage> = new ComponentStages<ProfileSwitcherStage>(ProfileSwitcherStage.Choice);

    constructor(private pService: ProfileComponentService, private service: ProfileSwitcherService) {}

    close() {
        this.pService.modals.switcher.close();
    }
}