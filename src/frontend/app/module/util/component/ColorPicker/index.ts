import {Component, Input, Output, EventEmitter} from "angular2/core";
import {FrontlineService} from "../../../frontline/service";

@Component({
    selector: 'cass-progress-bar',
    template: require('./template.html')
})
export class ColorPicker
{
    constructor(private frontline: FrontlineService){}

    @Input ('value') percent: number = 0;
    @Input ('allow-none') color: string = 'black';
    @Output ('change') change: any;
}