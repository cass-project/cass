import {Component} from "angular2/core";
import {FrontlineService} from "../../../frontline/service";
import {Palette} from "../../../util/definitions/palette";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ColorPickerDemo
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