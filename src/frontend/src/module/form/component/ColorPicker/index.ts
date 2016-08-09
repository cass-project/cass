import {Component, Input} from "@angular/core";
import {FrontlineService} from "../../../frontline/service";
import {Palette} from "../../../colors/definitions/entity/Palette";


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

    pickColor(palette: Palette){
        this.pickedColor = palette;
    }

    constructor(frontline: FrontlineService) {
        let palettes = frontline.session.config.palettes;


        for(let palette of palettes) {
            this.palettes.push(palette);
        }
    }
}