import {Injectable} from 'angular2/core';
import {Theme} from "../../theme/Theme";
import {ThemeRESTService} from "../../theme/service/ThemeRESTService";
import {ThemeTree} from "../../theme/Theme";

@Injectable()
export class ThemeEditorService
{
    themes: Theme[];
    showFormContentBox: boolean = false;
    themesTree: ThemeTree[];
    selectedThemeId: number;

    constructor(public themeRESTService: ThemeRESTService) {
        console.log('wtf');
    }

    public selectThemeId(themeId: number) {
        this.selectedThemeId = themeId;
        console.log(this.selectedThemeId);
        console.log(this.themes, this.themesTree);
    }

    public clear() {
        this.selectedThemeId = undefined;
    }
}