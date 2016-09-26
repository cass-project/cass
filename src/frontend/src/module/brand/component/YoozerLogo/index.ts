import {Component} from "@angular/core";

@Component({
    selector: 'yoozer-logo',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class YoozerLogo {}