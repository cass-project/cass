import {Component} from "@angular/core";

import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";

@Component({
    selector: 'cass-attachment-error-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class AttachmentErrorFeed
{
    private viewMode: ViewOptionValue = ViewOptionValue.Feed;
}