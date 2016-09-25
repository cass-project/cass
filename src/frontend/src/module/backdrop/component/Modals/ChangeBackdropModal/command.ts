import {Palette} from "../../../../colors/definitions/entity/Palette";
import {ColorEntity} from "../../../../colors/definitions/entity/Color";

export interface ChangeBackdropCommand
{
    actions: {
        image: string; // "untocuhed", "upload", "template", "delete"
        palette: string; // "untouched", "selected"
        textColor: string; // "untoched", "selected"
    },
    params: {
        presetId?: string;
        palette?: Palette;
        file?: Blob;
        textColor?: ColorEntity;
    }
}