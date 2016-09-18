import {Component} from "@angular/core";

@Component({
    selector: 'cass-loading-linear-indicator',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class LoadingLinearIndicator {}