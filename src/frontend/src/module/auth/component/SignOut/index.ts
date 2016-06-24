import {Component} from "angular2/core";

import {ModalComponent} from "../../../modal/component/index";
import {ModalBoxComponent} from "../../../modal/component/box/index";
import {LoadingLinearIndicator} from "../../../form/component/LoadingLinearIndicator/index";

@Component({
    selector: 'cass-auth-sign-out',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
        LoadingLinearIndicator
    ]
})
export class SignOutComponent
{
}