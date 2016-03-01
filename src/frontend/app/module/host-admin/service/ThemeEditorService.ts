import {Injectable} from 'angular2/core';
import {Theme} from "../../theme/Theme";
import {ThemeRESTService} from "../../theme/service/ThemeRESTService";

@Injectable()
export class ThemeEditorService
{
    selectedThemeId: number;

    constructor(public themeRESTService: ThemeRESTService) {
        console.log('wtf');
    }

    public selectThemeId(themeId: number) {
        this.selectedThemeId = themeId;
    }

    public clear() {
        this.selectedThemeId = undefined;
    }
}