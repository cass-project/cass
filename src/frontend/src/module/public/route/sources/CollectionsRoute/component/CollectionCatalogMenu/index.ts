import {Component, Input} from "@angular/core";

import {SwipeService} from "../../../../../../swipe/service/SwipeService";
import {UIService} from "../../../../../../ui/service/ui";
import {FeedCriteriaService} from "../../../../../../feed/service/FeedCriteriaService";
import {PublicService} from "../../../../../service";

@Component({
    selector: 'cass-collection-catalog-menu',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CollectionCatalogMenu
{
    @Input('is-extended') isExtended: boolean = false;

    constructor(
        private swipe: SwipeService,
        private ui: UIService,
        private criteria: FeedCriteriaService,
        private service: PublicService
    ) { }
}