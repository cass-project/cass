import {Component, Input} from "@angular/core";

@Component({
    selector: 'cass-progress-bar',
    template: require('./template.html')
})
export class ProgressBar
{
    @Input ('percent') percent: number = 0;
    @Input ('color') color: string = 'black';
    @Input ('type') type: string = 'default';
}