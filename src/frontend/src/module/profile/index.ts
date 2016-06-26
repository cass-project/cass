import {Component} from "angular2/core";

import {ProfileModal} from "./component/ProfileModal/index";
import {ModalComponent} from "../modal/component/index";
import {ProfileSwitcher} from "./component/ProfileSwitcher/index";
import {ProfileSetup} from "./component/ProfileSetup/index";
import {ModalBoxComponent} from "../modal/component/box/index";
import {ModalControl} from "../util/classes/ModalControl";

@Component({
    selector: 'cass-profile',
    template: require('./template.jade'),
    directives: [
        ModalComponent,
        ModalBoxComponent,
        ProfileModal,
        ProfileSwitcher,
        ProfileSetup
    ]
})
export class ProfileComponent
{
    public modals: {
        setup: ModalControl,
        settings: ModalControl,
        switcher: ModalControl,
    } = {
        setup: new ModalControl(),
        settings: new ModalControl(),
        switcher: new ModalControl(),
    };
}