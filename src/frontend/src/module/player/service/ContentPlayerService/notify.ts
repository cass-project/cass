import {Injectable} from "@angular/core";
import {Observable, Observer} from "rxjs";

import {AttachmentEntity} from "../../../attachment/definitions/entity/AttachmentEntity";

@Injectable()
export class ContentPlayerNotifier
{
    public play: Observable<AttachmentEntity<any>>;
    private playObserver: Observer<AttachmentEntity<any>>;

    constructor() {
        this.play = Observable.create(observer => {
            this.playObserver = observer;
        }).publish().refCount();
    }

    notifyAppAboutNewOpenedAttachment(attachment: AttachmentEntity<any>) {
        if(this.playObserver) {
            this.playObserver.next(attachment);
        }
    }
}