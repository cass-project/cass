import {Component, Input} from "@angular/core";

import {SwipeService} from "../../../../swipe/service/SwipeService";
import {UIService} from "../../../../ui/service/ui";
import {FeedCriteriaService} from "../../../../feed/service/FeedCriteriaService";
import {PublicService} from "../../../../public/service";

@Component({
    selector: 'cass-profile-catalog-menu',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class ProfileCatalogMenu
{
    @Input('is-extended') isExtended: boolean = false;

    constructor(
        private swipe: SwipeService,
        private ui: UIService,
        private criteria: FeedCriteriaService,
        private service: PublicService
    ) { }
}