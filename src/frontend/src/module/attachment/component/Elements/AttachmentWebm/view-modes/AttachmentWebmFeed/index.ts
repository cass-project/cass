import {Component, Input, Output, EventEmitter, OnChanges, OnInit, OnDestroy} from "@angular/core";

import {WebmAttachmentMetadata} from "../../../../../definitions/entity/metadata/WebmAttachmentMetadata";
import {AttachmentEntity} from "../../../../../definitions/entity/AttachmentEntity";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {AttachmentWebmHelper} from "../../helper";
import {AttachmentWebmNotifier} from "../../notify";
import {AttachmentYoutubeNotifier} from "../../../AttachmentYouTube/notify";
import {ContentPlayerService} from "../../../../../../player/service/ContentPlayerService/service";
import {Subscription} from "rxjs";
import {ContentPlayerNotifier} from "../../../../../../player/service/ContentPlayerService/notify";

@Component({
    selector: 'cass-attachment-webm-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class AttachmentWebmFeed implements OnChanges, OnInit, OnDestroy
{
    @Input('attachment') attachment: AttachmentEntity<WebmAttachmentMetadata>;

    @Output('open') openEvent: EventEmitter<AttachmentEntity<WebmAttachmentMetadata>> = new EventEmitter<AttachmentEntity<WebmAttachmentMetadata>>();

    private viewMode: ViewOptionValue = ViewOptionValue.Feed;
    private helper: AttachmentWebmHelper;

    private subscriptionY: Subscription;
    private subscriptionW: Subscription;
    private subscriptionC: Subscription;

    constructor(
        private notifyW: AttachmentWebmNotifier,
        private notifyY: AttachmentYoutubeNotifier,
        private notifyC: ContentPlayerNotifier,
        private contentPlayer: ContentPlayerService
    ) {}

    ngOnInit() {
        this.subscriptionW = this.notifyW.open.subscribe(attachment => {
            if(attachment.id !== this.attachment.id) {
                this.helper.rewindAndStop();
            }
        });

        this.subscriptionY = this.notifyY.open.subscribe(attachment => {
            this.helper.rewindAndStop();
        });

        this.subscriptionC = this.notifyC.play.subscribe(attachment => {
            this.helper.rewindAndStop();
        })
    }

    ngOnDestroy() {
        this.subscriptionW.unsubscribe();
        this.subscriptionY.unsubscribe();
    }

    ngOnChanges() {
        this.helper = new AttachmentWebmHelper(this.attachment);
    }

    open(attachment: AttachmentEntity<WebmAttachmentMetadata>): boolean {
        if(this.contentPlayer.isEnabled()) {
            this.openEvent.emit(attachment);
        }else{
            this.helper.rewindAndStart();
            this.notifyW.notifyAppAboutNewOpenedWebm(attachment);
        }

        return false;
    }
}