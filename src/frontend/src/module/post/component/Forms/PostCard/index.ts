import {Component, Input} from "angular2/core";

import {PostEntity} from "../../../definitions/entity/Post";
import {PostAttachment} from "../../../../post-attachment/component/Elements/PostAttachment/index";
import {ProfileCardHeader} from "../../../../profile/component/Elements/ProfileCardHeader/index";
import {ProfileEntity} from "../../../../profile/definitions/entity/Profile";
import {PostRESTService} from "../../../service/PostRESTService";
import {CurrentProfileService} from "../../../../profile/service/CurrentProfileService";
import {FeedService} from "../../../../feed/service/FeedService/index";
import {AuthService} from "../../../../auth/service/AuthService";

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

    deleteProcessing: boolean = false;

    constructor(private service: PostRESTService,
                private profile: CurrentProfileService,
                private feed: FeedService<PostEntity>,
                private auth: AuthService){}

    private dateCreatedOn: Date;

    isOwnPost(): boolean{
        if(this.auth.isSignedIn()){
            console.log(this.post.profile_id, this.profile.get().getId());
            return (this.post.profile_id === this.profile.get().getId());
        } else {
            return false
        }
    }

    deletePost(){
        this.deleteProcessing = true;
        this.service.deletePost(this.post.id).subscribe(success => {
            for(let index = 0; index < this.feed.stream.all().length; index++){
                if(this.feed.stream.all()[index].id = this.post.id){
                    this.feed.stream.all().splice(index, 1);
                    this.deleteProcessing = false;
                }
            }
        });
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