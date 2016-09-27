import {Component, Input} from '@angular/core';

import {SwipeService} from "../../../../../../swipe/service/SwipeService";
import {UIService} from "../../../../../../ui/service/ui";
import {FeedCriteriaService} from "../../../../../../feed/service/FeedCriteriaService";
import {ContentType} from "../../../../../../feed/definitions/request/criteria/ContentTypeCriteriaParams";
import {PublicService} from "../../../../../service";

@Component({
    selector: 'cass-public-content-menu',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class PublicContentMenu
{
    @Input('is-extended') isExtended: boolean = false;

    constructor(
        private swipe: SwipeService,
        private ui: UIService,
        private criteria: FeedCriteriaService,
        private service: PublicService
    ) { }

    private isContentType(contentType: ContentType) {
        return this.criteria.criteria.contentType.params.type === contentType;
    }

    disableContentTypeCriteria() {
        if(this.criteria.criteria.contentType.enabled) {
            this.criteria.criteria.contentType.enabled = false;
            this.criteria.criteria.contentType.params.type = undefined;
            this.service.update();
        }
    }

    enableContentTypeCriteria(contentType: ContentType) {
        if(! this.isContentType(contentType)) {
            this.criteria.criteria.contentType.enabled = true;
            this.criteria.criteria.contentType.params.type = contentType;
            this.service.update();
        }
    }
}