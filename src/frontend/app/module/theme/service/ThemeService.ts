import {Injectable} from 'angular2/core';
import {frontline, FrontlineService} from "../../frontline/service";

@Injectable()
export class ThemeService
{
    constructor(public frontlineService: FrontlineService){}

    themes;

    inInterestingZone: boolean = true;
    inExpertZone: boolean = false;


    pickedInterestingInThemes = this.frontlineService.session.auth.profiles[0].interesting_in;
    pickedExpertInThemes = this.frontlineService.session.auth.profiles[0].expert_in;

    themesTree = [
        {level: 0, themes: [], highlightActive: 0},
        {level: 1, themes: [], highlightActive: 0},
        {level: 2, themes: [], highlightActive: 0},
        {level: 3, themes: [], highlightActive: 0},
        {level: 4, themes: [], highlightActive: 0}];
    sessionTmp;


    treeToArray(tree, array) {
        for (let o of tree) {
            array.push(o);
            this.treeToArray(o.children, array);
        }
        array.push()
    }

    getThemeListAll(){
        let array = [];
        this.treeToArray(this.themesTree[1].themes, array);
        this.themes = array;
    }

    getThemeTreeList(){
        this.sessionTmp = this.frontlineService.session;
        this.themesTree[0].themes = this.sessionTmp.themes;
        if(this.themesTree[0].themes[0].children) {
            this.themesTree[1].themes = this.themesTree[0].themes[0].children;
        }
    }


    /*Usage: this.themeService.getThemeById(this.selectedTheme.id);*/
    getThemeById(themeId){
        for(let i of this.themes){
            if(i.id == themeId){
                return i;
            }
        }
    }

}

