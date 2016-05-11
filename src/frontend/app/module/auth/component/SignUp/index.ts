import {Component} from "angular2/core";
import {LoadingIndicator} from "../../../util/component/LoadingIndicator/index";
import {OAuth2Component} from "../OAuth2/index";

@Component({
    selector: 'cass-auth-sign-up',
    template: require('./template-stages.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        LoadingIndicator,
        OAuth2Component
    ]
})
export class SignUpComponent
{
}