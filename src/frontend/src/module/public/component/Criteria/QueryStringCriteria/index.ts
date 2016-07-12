import {Component, Output, EventEmitter} from "angular2/core";
import {PublicService} from "../../../service";

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

    constructor(private service: PublicService) {}

    ngSubmit() {
        this.updateCriteria();
    }

    updateCriteria() {
    }

    isSearchButtonDisabled() {
        return this.queryString.length === 0;
    }
}