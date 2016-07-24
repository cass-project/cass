import {Component, Input, EventEmitter, Output} from "angular2/core";

import {PostEntity} from "../../../definitions/entity/Post";
import {PostAttachment} from "../../../../post-attachment/component/Elements/PostAttachment/index";
import {ProfileCardHeader} from "../../../../profile/component/Elements/ProfileCardHeader/index";
import {ProfileEntity} from "../../../../profile/definitions/entity/Profile";
import {PostRESTService} from "../../../service/PostRESTService";
import {LoadingManager} from "../../../../common/classes/LoadingStatus";
import {Session} from "../../../../session/Session";

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

    @Output('attachment') attachmentEvent: EventEmitter<PostAttachment> = new EventEmitter<PostAttachment>();
    @Output('delete') deleteEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();

    private status: LoadingManager = new LoadingManager();

    constructor(
        private service: PostRESTService,
        private session: Session
    ) {}

    private dateCreatedOn: Date;

    isOwnPost(): boolean{
        if(this.session.isSignedIn()) {
            return this.post.profile_id === this.session.getCurrentProfile().getId();
        }else{
            return false;
        }
    }

    deletePost(){
        let loading = this.status.addLoading();

        this.service.deletePost(this.post.id).subscribe(
            response => {
                loading.is = false;

                this.deleteEvent.emit(this.post);
            },
            error => {
                loading.is = false;
            }
        );
    }
    
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