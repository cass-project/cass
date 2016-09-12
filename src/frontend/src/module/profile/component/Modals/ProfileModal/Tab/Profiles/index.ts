import {Component, Directive} from "@angular/core";
import {ProfileImage} from "../../../../Elements/ProfileImage/index";
import {ModalComponent} from "../../../../../../modal/component/index";
import {ProfilesTabService} from "./service";
import {ThemeService} from "../../../../../../theme/service/ThemeService";
import {ModalBoxComponent} from "../../../../../../modal/component/box/index";
import {ProfileModalModel} from "../../model";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ProfilesTabService
    ]
})
@Directive({selector: 'cass-profile-modal-tab-profiles'})

export class ProfilesTab
{
    constructor(private service: ProfilesTabService, private themeService: ThemeService, private model: ProfileModalModel) {}
}