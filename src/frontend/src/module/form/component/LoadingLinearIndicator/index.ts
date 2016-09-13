import {Component, Directive} from "@angular/core";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-loading-linear-indicator'})
export class LoadingLinearIndicator {}