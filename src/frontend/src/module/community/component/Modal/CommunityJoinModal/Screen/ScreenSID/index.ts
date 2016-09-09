import {Component} from "@angular/core";

import {Screen} from "../../screen";
import {LoadingLinearIndicator} from "../../../../../../form/component/LoadingLinearIndicator/index";

@Component({
    selector: 'cass-community-join-modal-screen-sid',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ScreenSID extends Screen
{}