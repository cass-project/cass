import {Component} from "@angular/core";

import {FeedService} from "../../../service/FeedService/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {PostIndexedEntity, PostEntity} from "../../../../post/definitions/entity/Post";
import {ContentPlayerService} from "../../../../player/service/ContentPlayerService/service";
import {PostPlayerService} from "../../../../post/component/Modals/PostPlayer/service";
import {PostListOpenAttachmentEvent} from "../../../../post/component/Elements/PostList/index";
import {PostRESTService} from "../../../../post/service/PostRESTService";
import {ModalControl} from "../../../../common/classes/ModalControl";

@Component({
    selector: 'cass-feed-post-stream',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class FeedPostStream
{
    constructor(
        private feed: FeedService<PostIndexedEntity>,
        private contentPlayer: ContentPlayerService,
        private postPlayer: PostPlayerService,
        private options: FeedOptionsService,
        private postRESTService: PostRESTService
    ) {}

    private currentPost: PostEntity;

    editPostModal: ModalControl = new ModalControl();
    deletePostModal: ModalControl = new ModalControl();
    reportPostModal: ModalControl = new ModalControl();


    getViewOption() {
        return this.options.view.current;
    }

    isContentPlayerEnabled(): boolean {
        return this.contentPlayer.isEnabled();
    }

    hasStream() {
        return typeof this.feed.stream === "object";
    }

    openEditPostModal(post: PostEntity){
        this.editPostModal.open();
        this.currentPost = post;
    }

    closeEditPostModal(){
        this.editPostModal.close();
        this.currentPost = undefined;
    }

    openDeletePostModal(post: PostEntity){
        this.deletePostModal.open();
        this.currentPost = post;
    }

    deletePost(id){
        this.feed.stream.deleteElement(id);
    }

    closeDeletePost(post: PostEntity){
        this.deletePostModal.close();
        this.currentPost = undefined;
    }

    pinPost(post: PostEntity){
        console.log(post)
    }

    openPost(post: PostEntity) {
        this.postPlayer.openPost(post);
    }

    openAttachment(event: PostListOpenAttachmentEvent) {
        if(this.contentPlayer.isEnabled() && this.contentPlayer.isSupported(event.attachment)) {
            this.contentPlayer.open(event.attachment);

            return false;
        }else{
            this.postPlayer.openPost(event.post);

            return false;
        }
    }
}