import {Component, EventEmitter, Output, OnChanges, Input, ViewChild, ElementRef} from "@angular/core";

import {Session} from "../../../../../../session/Session";
import {PostCardHelper} from "../../helper";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {PostEntity} from "../../../../../definitions/entity/Post";
import {AttachmentEntity} from "../../../../../../attachment/definitions/entity/AttachmentEntity";
import {MenuEntity} from "../../../../../../common/component/DropDownMenu/index";
import {TranslationService} from "../../../../../../i18n/service/TranslationService";

@Component({
    selector: 'cass-post-card-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
        require('./style.navigation.shadow.scss'),
    ]
})

export class PostCardFeed implements OnChanges
{
    @Input('post') private post: PostEntity;
    @Output('open-post') private openPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('open-attachment') private openAttachmentEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();
    @Output('edit-post') private editPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('delete-post') private deletePostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('pin-post') private pinPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    
    private menu: Array<MenuEntity> = [
        {title: this.translation.translate('dropdown.menu.my.post.card.edit'), action: 'Edit'},
        {title: this.translation.translate('dropdown.menu.my.post.card.delete'), action: 'Delete'},
        {title: this.translation.translate('dropdown.menu.my.post.card.pin'), action: 'Pin'}
    ];

    constructor(
        private session: Session,
        private translation: TranslationService
    ) {}
    
    private helper: PostCardHelper;
    private viewMode: ViewOptionValue = ViewOptionValue.Feed;
    
    
    ngOnChanges() {
        this.helper = new PostCardHelper(
            this.post,
            this.viewMode,
            this.menu,
            this.session, 
            this.openPostEvent,
            this.openAttachmentEvent,
            this.editPostEvent,
            this.deletePostEvent,
            this.pinPostEvent
        );
    }
}