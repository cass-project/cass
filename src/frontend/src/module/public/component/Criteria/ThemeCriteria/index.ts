import {Component} from "angular2/core";
import {SearchCriteriaService} from "../../../search/SearchCriteriaService";

@Component({
    selector: 'cass-public-search-criteria-theme',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ThemeCriteria
{
    constructor(private service: SearchCriteriaService) {}
}