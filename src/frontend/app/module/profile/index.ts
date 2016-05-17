import {Component} from "angular2/core";

import {ProfileComponentService} from "./service";
import {ProfileModal} from "./component/ProfileModal/index";
import {ModalComponent} from "../modal/component/index";
import {ProfileSwitcher} from "./component/ProfileSwitcher/index";
import {ProfileSetup} from "./component/ProfileSetup/index";

@Component({
    selector: 'cass-profile',
    template: require('./template.html'),
    directives: [
        ModalComponent,
        ProfileModal,
        ProfileSwitcher,
        ProfileSetup
    ]
})
export class ProfileComponent
{
    constructor(private service: ProfileComponentService) {}
}
