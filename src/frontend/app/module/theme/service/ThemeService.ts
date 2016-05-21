import {Injectable} from 'angular2/core';

import {FrontlineService} from "../../frontline/service";
import {ThemeTree} from "../entity/Theme";
import {ThemeSelect} from "../component/ThemeSelect/index";

@Injectable()
export class ThemeService
{
    root: ThemeTree;
    themes: ThemeTree[];
    themesMap = {};

    inInterestingZone: boolean = true;
    inExpertZone: boolean = false;
    expertIn = this.frontlineService.session.auth.profiles[0].expert_in;
    interestingIn = this.frontlineService.session.auth.profiles[0].interesting_in;

    
    constructor(public frontlineService: FrontlineService) {
        this.themes = frontlineService.session.themes;

        var convertTreeToMap = (themes: Array<ThemeTree>) => {
            for(let tree of themes) {
                this.themesMap[tree.id.toString()] = tree;

                if(tree.children.length) {
                    convertTreeToMap(tree.children);
                }
            }
        };

        convertTreeToMap(this.themes);
    }

    each(fn: { (theme: ThemeTree) }) {
        for(let n in this.themesMap) {
            if(this.themesMap.hasOwnProperty(n)) {
                fn(this.themesMap[n]);
            }
        }
    }

    findById(themeId: number): ThemeTree {
        if(this.themesMap.hasOwnProperty(themeId.toString())) {
            return this.themesMap[themeId.toString()];
        }else{
            throw new Error(`Theme '${themeId}' not found`);
        }
    }

    getRoot(): ThemeTree {
        return {
            id: 0,
            parent_id: 0,
            position: 0,
            title: 'ROOT',
            children: this.themes
        };
    }

    getAll(): Array<ThemeTree> {
        return this.themes;
    }
}
