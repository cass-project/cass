require('./stylesheets/main.scss');

import {Component} from 'angular2/core';

@Component({
    selector: 'app',
    template: require('./app.html')
})
export class App
{
    message:string = "Well, at least this works."
}