import {Component} from "@angular/core";

import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";

@Component({
    selector: 'cass-attachment-error-grid',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class AttachmentErrorGrid
{
    private viewMode: ViewOptionValue = ViewOptionValue.Grid;
}