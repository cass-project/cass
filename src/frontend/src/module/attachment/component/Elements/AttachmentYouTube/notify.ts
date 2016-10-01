import {Observable, Observer} from "rxjs";
import {Injectable} from "@angular/core";

import {AttachmentEntity} from "../../../definitions/entity/AttachmentEntity";
import {YoutubeAttachmentMetadata} from "../../../definitions/entity/metadata/YoutubeAttachmentMetadata";

@Injectable()
export class AttachmentYoutubeNotifier
{
    public open: Observable<AttachmentEntity<YoutubeAttachmentMetadata>>;

    private openObserver: Observer<AttachmentEntity<YoutubeAttachmentMetadata>>;

    constructor() {
        this.open = Observable.create(observer => {
            this.openObserver = observer;
        }).publish().refCount();
    }

    notifyAppAboutNewOpenedYoutube(attachment: AttachmentEntity<YoutubeAttachmentMetadata>) {
        this.openObserver.next(attachment);
    }
}