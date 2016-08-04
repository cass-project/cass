import {Component, Renderer} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";

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
    private globalListenFunc: Function;

    constructor(private service: AuthComponentService, renderer: Renderer) {
        this.globalListenFunc = renderer.listenGlobal('document', 'keyup', (event: KeyboardEvent) => {
            if(event.shiftKey && event.altKey && event.keyCode === 77 /* M */){
                this.service.authDev();
            }
        })
    }
}