import {Component} from "angular2/core";

import {ViewOption, ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {FeedOptionsService} from "../../../../feed/service/FeedOptionsService";
import {FeedCriteriaService} from "../../../../feed/service/FeedCriteriaService";
import {Criteria} from "../../../../feed/definitions/request/Criteria";
import {ContentTypeCriteriaParams, ContentType} from "../../../../feed/definitions/request/criteria/ContentTypeCriteriaParams";

@Component({
    selector: 'cass-public-option-view',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class OptionView
{
    private option: ViewOption;
    private contentType: Criteria<ContentTypeCriteriaParams>;

    constructor(
        private options: FeedOptionsService,
        private criteria: FeedCriteriaService
    ) {
        this.option = options.view;
        this.contentType = criteria.criteria.contentType;
    }
    
    current() {
        return this.option.current;
    }
    
    isOn(compare: ViewOptionValue) {
        return this.option.isOn(compare);
    }
    
    setAsCurrent(value: ViewOptionValue) {
        this.option.setAsCurrent(value);
    }

    isVideoPlayerAvailable(): boolean {
        return this.contentType.params.type === ContentType.Video;
    }
}