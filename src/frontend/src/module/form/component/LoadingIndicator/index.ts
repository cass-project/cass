import {Component, Directive} from "@angular/core";

@Component({
    template: require('./template.html')
})
@Directive({selector: 'cass-loading-indicator'})
export class LoadingIndicator {}