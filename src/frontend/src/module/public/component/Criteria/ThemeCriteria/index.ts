import {Component, Directive} from "@angular/core";

import {ThemeService} from "../../../../theme/service/ThemeService";
import {Theme} from "../../../../theme/definitions/entity/Theme";
import {PublicService} from "../../../service";
import {FeedCriteriaService} from "../../../../feed/service/FeedCriteriaService";
import {Criteria} from "../../../../feed/definitions/request/Criteria";
import {ThemeIdCriteriaParams} from "../../../../feed/definitions/request/criteria/ThemeIdCriteriaParams";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-public-search-criteria-theme'})

export class ThemeCriteria
{
    private root: Theme;
    private history: Theme[] = [];
    private criteria: Criteria<ThemeIdCriteriaParams>;

    constructor(
        private service: PublicService,
        private themes: ThemeService,
        feedCriteriaService: FeedCriteriaService
    ) {
        this.root = themes.getRoot();
        this.criteria = feedCriteriaService.criteria.theme;
    }

    getTitle() {
        if(this.root === undefined || this.root === null) {
            return 'Тематики';
        }else{
            return this.root.title;
        }
    }

    getRoot(): Theme {
        if(! this.criteria.enabled) {
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
        this.criteria.enabled = true;
        this.criteria.params.id = root.id;

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