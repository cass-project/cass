import {Component, Output, EventEmitter} from "angular2/core";

import {SearchCriteriaService} from "../../../search/SearchCriteriaService";

@Component({
    selector: 'cass-public-search-criteria-query-string',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class QueryStringCriteria
{
    private queryString: string = '';

    @Output('change') changeEvent = new EventEmitter<string>();

    constructor(private service: SearchCriteriaService) {}

    ngSubmit() {
        this.updateCriteria();
        this.service.update();
    }

    updateCriteria() {
        this.service.criteria.queryString.setQueryString(this.queryString);
    }

    isSearchButtonDisabled() {
        return this.queryString.length === 0;
    }
}