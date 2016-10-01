import {Component, Input} from "@angular/core";

import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {AttachmentErrorFeed} from "./view-modes/AttachmentErrorFeed/index";
import {AttachmentErrorGrid} from "./view-modes/AttachmentErrorGrid/index";
import {AttachmentErrorList} from "./view-modes/AttachmentErrorList/index";

@Component({
    selector: 'cass-attachment-error',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class AttachmentError
{
    @Input('viewMode') viewMode: ViewOptionValue = ViewOptionValue.Feed;

    isViewMode(viewMode: ViewOptionValue): boolean {
        return viewMode === this.viewMode;
    }
}

export const ATTACHMENT_ERROR_DIRECTIVES = [
    AttachmentError,
    AttachmentErrorFeed,
    AttachmentErrorGrid,
    AttachmentErrorList,
];