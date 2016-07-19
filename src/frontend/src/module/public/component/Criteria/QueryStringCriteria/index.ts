import {Component, Output, EventEmitter} from "angular2/core";
import {PublicService} from "../../../service";
import {ThemeService} from "../../../../theme/service/ThemeService";
import {FeedService} from "../../../../feed/service/FeedService/index";

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

    constructor(
        private service: PublicService,
        private themes: ThemeService
    ) {}

    submit() {
        this.updateCriteria();
    }

    isCriteriaAvailable(): boolean {
        return this.queryString.length >= 3;
    }

    updateCriteria() {
        if(this.isCriteriaAvailable()) {
            if(this.service.criteria.has('query_string')) {
                this.service.criteria.doWith('query_string', criteria => {
                    criteria.params.query_string = this.queryString;
                });
            }else{
                this.service.criteria.attach({
                    code: 'query_string',
                    params: {
                        query: this.queryString
                    }
                });
            }
        }
        
        this.service.update();
    }

    isSearchButtonDisabled() {
        return ! this.isCriteriaAvailable();
    }

    isThemeCriteriaAvailable(): boolean {
        return this.service.criteria.has('theme_id')
            && Number(this.service.criteria.getByCode('theme_id').params.id) > 0;
    }

    getThemeTitle(): string {
        if(this.isThemeCriteriaAvailable()) {
            return this.themes.findById(Number(this.service.criteria.getByCode('theme_id').params.id)).title;
        }else{
            throw 'Theme is not available!';
        }
    }

    removeThemeCriteria() {
        this.service.criteria.detachByCode('theme_id');
        this.service.update();
    }
}