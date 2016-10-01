import {Observable, Observer} from "rxjs";
import {Injectable} from "@angular/core";

import {AttachmentEntity} from "../../../definitions/entity/AttachmentEntity";
import {WebmAttachmentMetadata} from "../../../definitions/entity/metadata/WebmAttachmentMetadata";

@Injectable()
export class AttachmentWebmNotifier
{
    public open: Observable<AttachmentEntity<WebmAttachmentMetadata>>;

    private openObserver: Observer<AttachmentEntity<WebmAttachmentMetadata>>;

    constructor() {
        this.open = Observable.create(observer => {
            this.openObserver = observer;
        }).publish().refCount();
    }

    notifyAppAboutNewOpenedWebm(attachment: AttachmentEntity<WebmAttachmentMetadata>) {
        this.openObserver.next(attachment);
    }
}