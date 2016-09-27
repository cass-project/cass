import {Component, Input} from "@angular/core";

import {Palette} from "../../../colors/definitions/entity/Palette";
import {FrontlineService} from "../../../frontline/service/FrontlineService";

@Component({
    selector: 'cass-palette-picker',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class PalettePicker
{
    private palettes: Palette[] = [];

    @Input('value') value: Palette;

    select(palette: Palette){
        this.value = palette;
    }

    constructor(frontline: FrontlineService) {
        let palettes = frontline.session.config.palettes;

        for(let code in palettes) {
            if(palettes.hasOwnProperty(code)) {
                this.palettes.push(palettes[code]);
            }
        }
    }
}