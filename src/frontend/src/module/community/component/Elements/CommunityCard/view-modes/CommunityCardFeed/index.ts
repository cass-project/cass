import {Component, Input} from "@angular/core";

import {CommunityCardHelper} from "../../helper";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {CommunityEntity} from "../../../../../definitions/entity/Community";

@Component({
    selector: 'cass-community-card-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityCardFeed
{
    private viewMode: ViewOptionValue = ViewOptionValue.Feed;
    
    constructor(
        private helper: CommunityCardHelper
    ) {}
}