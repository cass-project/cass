import {Component, OnChanges, Input, Output, EventEmitter, OnInit, OnDestroy} from "@angular/core";
import {Subscription} from "rxjs";

import {AttachmentEntity} from "../../../../../definitions/entity/AttachmentEntity";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {AttachmentYoutubeHelper} from "../../helper";
import {YoutubeAttachmentMetadata} from "../../../../../definitions/entity/metadata/YoutubeAttachmentMetadata";
import {ContentPlayerService} from "../../../../../../player/service/ContentPlayerService/service";
import {AttachmentYoutubeNotifier} from "../../notify";
import {AttachmentWebmNotifier} from "../../../AttachmentWebm/notify";

@Component({
    selector: 'cass-attachment-youtube-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class AttachmentYouTubeFeed implements OnChanges, OnInit, OnDestroy
{
    @Input('attachment') attachment: AttachmentEntity<YoutubeAttachmentMetadata>;
    @Output('open') openEvent: EventEmitter<AttachmentEntity<YoutubeAttachmentMetadata>> = new EventEmitter<AttachmentEntity<YoutubeAttachmentMetadata>>();

    private subscriptionY: Subscription;
    private subscriptionW: Subscription;

    private viewMode: ViewOptionValue = ViewOptionValue.Feed;
    private helper: AttachmentYoutubeHelper;

    constructor(
        private notifyY: AttachmentYoutubeNotifier,
        private notifyW: AttachmentWebmNotifier,
        private contentPlayer: ContentPlayerService
    ) {}

    ngOnInit() {
        this.subscriptionY = this.notifyY.open.subscribe(attachment => {
            if(attachment.id !== this.attachment.id) {
                this.helper.enablePreview();
            }
        });

        this.subscriptionW = this.notifyW.open.subscribe(attachment => {
            this.helper.enablePreview();
        })
    }

    ngOnDestroy() {
        this.subscriptionY.unsubscribe();
        this.subscriptionW.unsubscribe();
    }

    ngOnChanges() {
        this.helper = new AttachmentYoutubeHelper(this.attachment);
    }

    open(attachment: AttachmentEntity<YoutubeAttachmentMetadata>): boolean {
        if(this.contentPlayer.isEnabled()) {
            this.openEvent.emit(attachment);
        }else{
            this.helper.disablePreview();
            this.notifyY.notifyAppAboutNewOpenedYoutube(attachment);
        }

        return false;
    }
}