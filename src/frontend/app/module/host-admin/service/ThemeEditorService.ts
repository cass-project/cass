import {Injectable} from 'angular2/core';
import {Theme} from "../../theme/Theme";
import {ThemeRESTService} from "../../theme/service/ThemeRESTService";
import {ThemeTree} from "../../theme/Theme";
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';

@Injectable()
export class ThemeEditorService
{
    theme;
    themes: Theme[];
    showFormContentBox: boolean = false;
    themesTree: ThemeTree[];
    selectedThemeId: number;
    createFirstParent: boolean = false;

    constructor(public themeRESTService: ThemeRESTService,
                public router: Router) {
    }

    public selectThemeId(themeId: number) {
        this.selectedThemeId = themeId;
        console.log(this.selectedThemeId);
    }

    public updateInfoOnPage(){
        this.themeRESTService.getThemesTree().map(res => res.json()).subscribe(data => this.themesTree = data['entities']);
        this.themeRESTService.getThemes().map(res => res.json()).subscribe(data => this.themes = data['entities']);
        this.showFormContentBox = false;
    }

    public clear() {
        this.selectedThemeId = undefined;
    }
}