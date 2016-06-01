import {Component} from "angular2/core";
import {ProfileImage} from "../../../ProfileImage/index";
import {ModalComponent} from "../../../../../modal/component/index";
import {ProfilesTabService} from "./service";
import {ThemeService} from "../../../../../theme/service/ThemeService";

@Component({
    selector: 'cass-profile-modal-tab-profiles',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ProfilesTabService
    ],
    directives: [
        ModalComponent,
        ProfileImage
    ],
})
export class ProfilesTab
{
    constructor(private service: ProfilesTabService, private themeService: ThemeService) {}
}