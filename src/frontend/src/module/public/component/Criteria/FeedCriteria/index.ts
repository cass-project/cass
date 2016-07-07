import {Component} from "angular2/core";

import {SearchCriteriaService} from "../../../search/SearchCriteriaService";
import {FeedCriteriaValue} from "../../../search/criteria/FeedCriteria";

@Component({
    selector: 'cass-public-search-criteria-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class FeedCriteria
{
    constructor(private service: SearchCriteriaService) {}
    
    setFeedType(feedType: FeedCriteriaValue) {
        this.service.criteria.feed.setValue(feedType);
    }
    
    isOn(feedType: FeedCriteriaValue) {
        return this.service.criteria.feed.getValue() === feedType;
    }
}