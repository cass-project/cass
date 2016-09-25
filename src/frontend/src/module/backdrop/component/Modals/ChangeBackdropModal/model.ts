import {Injectable} from "@angular/core";

import {FrontlineService} from "../../../../frontline/service/FrontlineService";
import {ColorEntity} from "../../../../colors/definitions/entity/Color";

@Injectable()
export class ChangeBackdropModel
{
    private textColors: ColorEntity[] = [];

    constructor(
        private frontline: FrontlineService
    ) {
        let palettes = frontline.session.config.palettes;

        this.textColors.push({ code: 'white', hexCode: '#ffffff' });
        this.textColors.push({ code: 'black', hexCode: '#000000' });

        for(let code in palettes) {
            if(palettes.hasOwnProperty(code)) {
                this.textColors.push(palettes[code].background);
                this.textColors.push(palettes[code].border);
            }
        }

        console.log(this.textColors);
    }

    private getTextColors(): ColorEntity[] {
        return this.textColors;
    }
}