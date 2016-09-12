import {Component, Directive} from "@angular/core";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-loading-linear-indicator'})
export class LoadingLinearIndicator {}