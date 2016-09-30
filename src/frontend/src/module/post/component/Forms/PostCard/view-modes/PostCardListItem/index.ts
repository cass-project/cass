import {Component, EventEmitter} from "@angular/core";

import {Input, Output} from "@angular/core/src/metadata/directives";
import {PostEntity} from "../../../../../definitions/entity/Post";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";

@Component({
    selector: 'cass-post-card-list-item',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class PostCardListItem
{
    @Input('post') post: PostEntity;
    @Input('view-mode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Input('content-player-enabled') contentPlayerEnabled: boolean = false;
    @Output('go') goEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();

    go() {
        this.goEvent.emit(this.post);
    }
}