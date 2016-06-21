import {Component, Input} from "angular2/core";
import {FrontlineService} from "../../../frontline/service";
import {Palette} from "../../../util/definitions/palette";


@Component({
    selector: 'cass-color-picker',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ColorPicker
{
    
    private palettes: Palette[] = [];

    @Input('pickedColor') pickedColor;

    pickColor(palette){
        this.pickedColor = palette;
    }

    constructor(frontline: FrontlineService) {
        let colors = frontline.session.config.colors;


        for(let n in colors) {
            if(colors.hasOwnProperty(n)) {
                this.palettes.push(colors[n]);
            }
        }
    }
}