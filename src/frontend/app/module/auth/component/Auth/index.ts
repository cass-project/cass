import {Component} from "angular2/core";

import {ModalComponent} from "../../../modal/component/index";
import {SignInComponent} from "../SignIn/index";
import {SignUpComponent} from "../SignUp/index";
import {SignOutComponent} from "../SignOut/index";

@Component({
    selector: 'cass-auth',
    template: require('./template.html'),
    directives: [
        ModalComponent,
        SignInComponent,
        SignUpComponent,
        SignOutComponent
    ],
    styles: [
        require('./style.shadow.scss')
    ]
})
export class AuthComponent
{
}