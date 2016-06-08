/*import {Component, Input, Output, EventEmitter} from "angular2/core";
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
    @Output ('change') change = new EventEmitter();
}*/

import {Component} from "angular2/core";
import {FrontlineService} from "../../../frontline/service";
import {Palette} from "../../../util/definitions/palette";


@Component({
    selector: 'colorPicker',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ColorPicker
{

private palettes: Palette[] = [];

constructor(frontline: FrontlineService) {
    let colors = frontline.session.config.colors;

    for(let n in colors) {
        if(colors.hasOwnProperty(n)) {
            this.palettes.push(colors[n]);
        }
    }
}
}