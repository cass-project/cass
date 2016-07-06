import {Component} from "angular2/core";
import {SearchCriteriaService} from "../../../search/SearchCriteriaService";
import {ThemeService} from "../../../../theme/service/ThemeService";
import {Theme} from "../../../../theme/definitions/entity/Theme";

@Component({
    selector: 'cass-public-search-criteria-theme',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ThemeCriteria
{
    private root: Theme;
    private history: Theme[] = [];

    constructor(
        private service: SearchCriteriaService,
        private themes: ThemeService
    ) {
        this.root = themes.getRoot();
    }

    getTitle() {
        if(this.root === undefined || this.root === null) {
            return 'Тематики';
        }else{
            return this.root.title;
        }
    }

    getRoot(): Theme {
        return this.root;
    }
    
    back() {
        if(this.history.length > 1) {
            this.history.pop();
            this.root = this.history[this.history.length - 1];
        }else{
            this.root = this.themes.getRoot();
            this.history = [];
        }
    }
    
    hasBack(): boolean {
        return this.history.length > 0;
    }

    selectRoot(root: Theme) {
        this.service.criteria.theme.setThemeId(root.id);

        if(root.children.length > 0) {
            this.root = root;
            this.history.push(root);
        }
    }

    isSelected(id: number) {
        return this.service.criteria.theme.getThemeId() === id;
    }
}