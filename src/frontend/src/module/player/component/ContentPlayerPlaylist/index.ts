import {Component, Input, Output, EventEmitter} from "@angular/core";

import {AttachmentEntity} from "../../../attachment/definitions/entity/AttachmentEntity";
import {Playlist} from "../../service/ContentPlayerService/playlist";

require('./style.head.scss');

@Component({
    selector: 'cass-content-player-playlist',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class ContentPlayerPlaylist
{
    @Input('playlist') playlist: Playlist;
    @Output('play') playEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();

    isItem(resource: string, attachment: AttachmentEntity<any>): boolean {
        return attachment.link.resource === resource;
    }

    isCurrent(attachment: AttachmentEntity<any>): boolean {
        return (this.playlist.has(attachment))
            && (this.playlist.getCurrent() === attachment);
    }

    play(attachment: AttachmentEntity<any>) {
        this.playEvent.emit(attachment);
    }
}