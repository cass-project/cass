import {Injectable} from 'angular2/core';
import {Http, URLSearchParams} from 'angular2/http';
import {frontline, FrontlineService} from "../../frontline/service";

@Injectable()
export class ThemeService
{
    constructor(public http: Http, public frontlineService: FrontlineService){}

    themes;

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
        this.themesTree[1].themes = this.themesTree[0].themes[0].children;
    }

    getThemeById(themeId){
        let url = `backend/api/theme/${themeId}/get`;

        return this.http.get(url);
    }

}

