import {AttachmentEntity} from "../../../attachment/definitions/entity/AttachmentEntity";
import {ContentPlayerService} from "./service";

export class Controls
{
    constructor(private service: ContentPlayerService) {}

    play(attachment: AttachmentEntity<any>) {
        this.service.playlist.setAsCurrent(attachment);
    }

    next() {
        this.service.playlist.next();
    }

    prev() {
        this.service.playlist.prev();
    }

    shuffle() {
        this.service.playlist.shuffle();
    }

    empty() {
        this.service.playlist.emptyExlcudeCurrent();
    }

    hide() {
        this.service.hide();
    }
}