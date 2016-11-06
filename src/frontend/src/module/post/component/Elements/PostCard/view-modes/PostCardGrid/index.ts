import {Component, EventEmitter, Output, OnChanges, Input} from "@angular/core";

import {Session} from "../../../../../../session/Session";
import {PostCardHelper} from "../../helper";
import {PostEntity} from "../../../../../definitions/entity/Post";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {AttachmentEntity} from "../../../../../../attachment/definitions/entity/AttachmentEntity";
import {QueryTarget, queryImage} from "../../../../../../avatar/functions/query";

@Component({
    selector: 'cass-post-card-grid',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
        require('./style.navigation.shadow.scss'),
    ]
})

export class PostCardGrid implements OnChanges
{
    @Input('post') private post: PostEntity;
    @Input('show-controls') showControls: boolean = true;
    @Output('open-post') private openPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('open-attachment') private openAttachmentEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();
    @Output('edit-post') private editPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('delete-post') private deletePostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('pin-post') private pinPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();

    private static ICONS_MAP = {
        'image': 'fa fa-camera-retro',
        'youtube': 'fa fa-film',
        'webm': 'fa fa-film',
        'page': 'fa fa-external-link',
    };

    private viewMode: ViewOptionValue = ViewOptionValue.Grid;

    constructor(
        private helper: PostCardHelper,
        private session: Session,
    ) {}

    ngOnChanges() {
        this.helper.setup({
            post: this.post,
            viewMode: this.viewMode,
            openPostEvent: this.openPostEvent,
            openAttachmentEvent: this.openAttachmentEvent,
            editPostEvent: this.editPostEvent,
            deletePostEvent: this.deletePostEvent,
            pinPostEvent: this.pinPostEvent
        });
    }

    getFAIcon(): string {
        if(this.helper.hasAttachment()) {
            let resource = this.post.attachments[0].link.resource;

            if(PostCardGrid.ICONS_MAP.hasOwnProperty(resource)) {
                return PostCardGrid.ICONS_MAP[resource];
            }else{
                return 'fa fa-file-o';
            }
        }else{
            return 'fa fa-file-text-o';
        }
    }

    getProfileImageURL(): string {
        return queryImage(QueryTarget.Avatar, this.post.profile.image).public_path;
    }

    openPost(post: PostEntity) {
        this.openPostEvent.emit(post);
    }
}