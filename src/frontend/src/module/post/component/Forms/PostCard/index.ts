import {Component, Input} from "angular2/core";

import {PostEntity} from "../../../definitions/entity/Post";
import {PostAttachment} from "../../../../post-attachment/component/Elements/PostAttachment/index";
import {ProfileCardHeader} from "../../../../profile/component/Elements/ProfileCardHeader/index";
import {ProfileEntity} from "../../../../profile/definitions/entity/Profile";

@Component({
    selector: 'cass-post-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        PostAttachment,
        ProfileCardHeader,
    ]
})
export class PostCard
{
    @Input('post') post: PostEntity;

    private dateCreatedOn: Date;

    getProfile(): ProfileEntity
    {
        return this.post.profile;
    }

    getPostDateCreatedOn(): Date
    {
        if(! this.dateCreatedOn) {
            this.dateCreatedOn = new Date(this.post.date_created_on);
        }

        return this.dateCreatedOn;
    }

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