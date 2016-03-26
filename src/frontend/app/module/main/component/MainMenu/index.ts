import {Component} from 'angular2/core';
import {ROUTER_DIRECTIVES} from 'angular2/router'

@Component({
    selector: 'cass-main-menu',
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES
    ],
    styles: [
        require('./style.shadow.scss')
    ]
})
export class MainMenu
{
}