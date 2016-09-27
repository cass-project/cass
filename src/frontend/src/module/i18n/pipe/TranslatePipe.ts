import {PipeTransform, Pipe} from "@angular/core";

import {TranslationService} from "../service/TranslationService";

@Pipe({
    name: 'translate'
})
export class TranslatePipe implements PipeTransform
{
    constructor(private i18n: TranslationService) {}

    transform(value: string, ...args: any[]): string {
        return this.i18n.translate(value);
    }
}