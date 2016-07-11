import {Component, Input} from "angular2/core";

import {PostEntity} from "../../../definitions/entity/Post";
import {PostAttachment} from "../../../../post-attachment/component/Elements/PostAttachment/index";

@Component({
    selector: 'cass-post-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        PostAttachment
    ]
})
export class PostCard
{
    @Input('post') post: PostEntity;

    getContent(): string {
        return this.post.content;
    }

    hasContent(): boolean {
        return this.post.content && this.post.content.length > 0;
    }

    hasAttachment(): boolean {
        return this.post.attachments.length > 0;
    }
    
    getAttachment() {
        return this.post.attachments[0];
    }
}