import {Component, Input} from "@angular/core";

@Component({
    template: require('./template.html')
,selector: 'cass-progress-bar'})

export class ProgressBar
{
    @Input ('percent') percent: number = 0;
    @Input ('color') color: string = 'black';
    @Input ('type') type: string = 'default';
}