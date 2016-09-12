import {Component, Input, Directive} from "@angular/core";

@Component({
    template: require('./template.html')
})
@Directive({selector: 'cass-progress-bar'})

export class ProgressBar
{
    @Input ('percent') percent: number = 0;
    @Input ('color') color: string = 'black';
    @Input ('type') type: string = 'default';
}