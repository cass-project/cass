import {Injectable} from "@angular/core";

import {FrontlineService} from "../../../../frontline/service/FrontlineService";
import {ColorEntity} from "../../../../colors/definitions/entity/Color";
import {Backdrop} from "../../../definitions/Backdrop";
import { ProfileEntity } from "../../../../profile/definitions/entity/Profile";

@Injectable()
export class ChangeBackdropModel
{
    public backdrop: Backdrop<any>;
    public sampleText: string;
    public profile: ProfileEntity;
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
    
    public exportProfile(profile: ProfileEntity){
        this.profile = profile;
    }

    public setTextColor(color: ColorEntity) {
        this.textColor = color;
        console.log(this.textColor);
    }

    private getTextColors(): ColorEntity[] {
        return this.textColors;
    }
}