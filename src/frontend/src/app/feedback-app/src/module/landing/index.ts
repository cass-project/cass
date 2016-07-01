import {Component} from "angular2/core";
import {RouterOutlet} from "angular2/router";

@Component({
    selector: 'cass-feedback-landing',
    template: require('./template.jade'),
    directives: [
        RouterOutlet
    ],
})
export class IndexComponent {}