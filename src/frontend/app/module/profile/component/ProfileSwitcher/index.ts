import {Component} from "angular2/core";

import {ProfileImage} from "../ProfileImage/index";
import {ComponentStages} from "../../../util/classes/ComponentStages";
import {LoadingLinearIndicator} from "../../../util/component/LoadingLinearIndicator/index";
import {ProfileComponentService} from "../../service";
import {AuthService} from "../../../auth/service/AuthService";
import {ProfileSwitcherService} from "./service";

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