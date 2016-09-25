import {Injectable} from "@angular/core";

import {FrontlineService} from "../../../../frontline/service/FrontlineService";
import {ColorEntity} from "../../../../colors/definitions/entity/Color";
import {Backdrop} from "../../../definitions/Backdrop";

@Injectable()
export class ChangeBackdropModel
{
    public backdrop: Backdrop<any>;
    public sampleText: string;
    public textColor: ColorEntity = { code: 'white', hexCode: '#ffffff' };

    private textColors: ColorEntity[] = [];

    constructor(
        private frontline: FrontlineService
    ) {
        let palettes = frontline.session.config.palettes;

        this.textColors.push({ code: 'black', hexCode: '#000000' });
        this.textColors.push({ code: 'white', hexCode: '#ffffff' });

        for(let code in palettes) {
            if(palettes.hasOwnProperty(code)) {
                this.textColors.push(palettes[code].background);
                this.textColors.push(palettes[code].border);
            }
        }
    }

    public exportBackdrop(backdrop: Backdrop<any>) {
        this.backdrop = JSON.parse(JSON.stringify(backdrop));
    }

    public exportSampleText(sampleText: string) {
        this.sampleText = sampleText;
    }

    public setTextColor(color: ColorEntity) {
        this.textColor = color;
    }

    private getTextColors(): ColorEntity[] {
        return this.textColors;
    }
}