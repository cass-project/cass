import {Component} from 'angular2/core';
import {AuthControlsComponent} from '../../../auth/component/AuthControlsComponent/index';
import {ROUTER_DIRECTIVES} from 'angular2/router';

@Component({
    selector: 'cass-header-bar',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
        AuthControlsComponent
    ]
})
export class HeaderNavComponent
{
}