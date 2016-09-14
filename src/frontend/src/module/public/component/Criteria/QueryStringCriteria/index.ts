import {Component, Output, EventEmitter, Directive} from "@angular/core";

import {PublicService} from "../../../service";
import {ThemeService} from "../../../../theme/service/ThemeService";
import {FeedCriteriaService} from "../../../../feed/service/FeedCriteriaService";
import {Criteria} from "../../../../feed/definitions/request/Criteria";
import {QueryStringCriteriaParams} from "../../../../feed/definitions/request/criteria/QueryStringCriteriaParams";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-public-search-criteria-query-string'})

export class QueryStringCriteria
{
    private queryString: string = '';
    private query: Criteria<QueryStringCriteriaParams>;

    @Output('change') changeEvent = new EventEmitter<string>();

    constructor(
        private service: PublicService,
        private themes: ThemeService,
        private criteria: FeedCriteriaService
    ) {
        this.query = criteria.criteria.query;
    }

    submit() {
        this.updateCriteria();
    }

    isCriteriaAvailable(): boolean {
        return this.queryString.length >= 3;
    }

    updateCriteria() {
        this.query.enabled = this.isCriteriaAvailable();

        if(this.query.enabled) {
            this.query.params.query = this.queryString;
            this.service.update();
        }
    }

    isSearchButtonDisabled() {
        return ! this.isCriteriaAvailable();
    }

    isThemeCriteriaAvailable(): boolean {
        return this.criteria.criteria.theme.enabled
            && Number(this.criteria.criteria.theme.params.id) > 0;
    }

    getThemeTitle(): string {
        if(this.isThemeCriteriaAvailable()) {
            return this.themes.findById(Number(this.criteria.criteria.theme.params.id)).title;
        }else{
            throw 'Theme is not available!';
        }
    }

    removeThemeCriteria() {
        this.criteria.criteria.theme.enabled = false;
        this.service.update();
    }
}