import {Injectable} from "@angular/core";

@Injectable()
export class TranslationService
{
    private target = 'ru';
    private fallback = 'en';
    private dictionaries = {
        ru: require('./../../../translations/ru.json'),
        en: require('./../../../translations/ru.json'),
    };

    translate(key: string): string {
        if(this.dictionaries[this.target][key] !== undefined) {
            return this.dictionaries[this.target][key];
        }else if(this.dictionaries[this.fallback][key] !== undefined) {
            console.log(`TranslationService: Using fallback for ${key}`); /* DO NOT REMOVE FKING BITCH */

            return this.dictionaries[this.fallback][key];
        }else{
            throw new Error(`Cannot translate key ${key}!`)
        }
    }
}