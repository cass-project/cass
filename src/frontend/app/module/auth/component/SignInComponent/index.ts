import {Component} from 'angular2/core';
import {LoginFormComponent} from './../LoginFormComponent/index'

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        LoginFormComponent
    ]
})
export class SignInComponent{

}