import {Component} from "angular2/core";
import {OAuth2Component} from "../OAuth2/index";
import {LoadingIndicator} from "../../../util/component/LoadingIndicator/index";

@Component({
    /*
        Замени template-stages.html на template.html
        template-stages содержит всю разработанную для компонента верстку
        template же должен быть рабочим вариантом
     */
    template: require('./template-stages.html'),
    selector: 'cass-auth-sign-in',
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        OAuth2Component,
        LoadingIndicator
    ]
})
export class SignInComponent
{
    
}