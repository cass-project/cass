import {Component} from "@angular/core";

import {FeedCriteriaService} from "../../../../feed/service/FeedCriteriaService";
import {Criteria} from "../../../../feed/definitions/request/Criteria";
import {ContentTypeCriteriaParams, ContentType} from "../../../../feed/definitions/request/criteria/ContentTypeCriteriaParams";
import {PublicService} from "../../../service";

@Component({
    selector: 'cass-public-criteria-content-type',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ContentTypeCriteria
{
    private criteria: Criteria<ContentTypeCriteriaParams>;

    constructor(
        private criteria: FeedCriteriaService,
        private service: PublicService
    ) {
        this.criteria = criteria.criteria.contentType;
    }

    ngOnDestroy() {
        this.criteria.enabled = false;
    }

    setContentType(contentType: ContentType) {
        this.criteria.enabled = true;
        this.criteria.params.type = contentType;
        this.service.update();
    }

    reset() {
        this.criteria.enabled = false;
        this.criteria.params.type = undefined;
        this.service.update();
    }

    is(contentType: ContentType) {
        return this.criteria.enabled && (this.criteria.params.type === contentType);
    }

    isEnabled() {
        return this.criteria.enabled && this.criteria.params.type !== undefined;
    }
}