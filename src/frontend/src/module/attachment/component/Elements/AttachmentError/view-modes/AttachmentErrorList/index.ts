import {Component} from "@angular/core";

import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";

@Component({
    selector: 'cass-attachment-error-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class AttachmentErrorList
{
    private viewMode: ViewOptionValue = ViewOptionValue.List;
}