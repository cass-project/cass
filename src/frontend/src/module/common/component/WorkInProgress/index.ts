import {Component, Directive} from "@angular/core";

@Component({
    template: require('./template.html')
})
@Directive({selector: 'work-in-progress'})
export class WorkInProgress {}