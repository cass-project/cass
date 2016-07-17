import {Component} from "angular2/core";

import {ThemeService} from "../../../../theme/service/ThemeService";
import {Theme} from "../../../../theme/definitions/entity/Theme";
import {PublicService} from "../../../service";

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
        private service: PublicService,
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
        if(! this.service.criteria.has('theme_id')) {
            this.reset();
        }

        return this.root;
    }

    reset() {
        this.history = [];
        this.root = this.themes.getRoot();
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
        if(this.service.criteria.has('theme_id')) {
            this.service.criteria.doWith('theme_id', criteria => {
                criteria.params['id'] = root.id;
            });
        }else{
            this.service.criteria.attach({
                code: 'theme_id',
                params: {
                    'id': root.id
                }
            });
        }

        if(root.children.length > 0) {
            this.root = root;
            this.history.push(root);
        }

        this.service.update();
    }

    isSelected(id: number) {
        return this.root.id === id;
    }
}