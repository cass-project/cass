import {Component, Renderer} from "@angular/core";
import {CORE_DIRECTIVES} from "@angular/common";

import {ModalComponent} from "../../../modal/component/index";
import {SignInComponent} from "../SignIn/index";
import {SignUpComponent} from "../SignUp/index";
import {AuthComponentService} from "./service";
import {ModalBoxComponent} from "../../../modal/component/box/index";
import {AuthDev} from "../../../auth-dev/component/index";

@Component({
    selector: 'cass-auth',
    template: require('./template.jade'),
    directives: [
        CORE_DIRECTIVES,
        ModalComponent,
        ModalBoxComponent,
        SignInComponent,
        SignUpComponent,
        AuthDev
    ],
    styles: [
        require('./style.shadow.scss')
    ]
})
export class AuthComponent
{
    constructor(private service: AuthComponentService, renderer: Renderer) {
        renderer.listenGlobal('document', 'keyup', (event:KeyboardEvent) => {
            if (event.shiftKey && event.altKey && event.keyCode === 77 /* M */) {
                if (this.service.modals.authDev.isOpened()) {
                    this.service.closeAllModals();
                } else {
                    this.service.authDev();
                }
            }
        })
    }
}