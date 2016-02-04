import {Component} from 'angular2/core';
import {RouteConfig, RouterOutlet} from 'angular2/router';

@Component({
    template: require('./template.html'),
    directives: [RouterOutlet],
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class WelcomeComponent {}