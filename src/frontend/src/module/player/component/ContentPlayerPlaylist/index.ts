import {Component, Input} from "@angular/core";

import {AttachmentEntity} from "../../../attachment/definitions/entity/AttachmentEntity";
import {Playlist} from "../../service/ContentPlayerService/playlist";

@Component({
    selector: 'cass-content-player-playlist',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ContentPlayerPlaylist
{
    @Input('playlist') playlist: Playlist;

    isItem(resource: string, attachment: AttachmentEntity<any>): boolean {
        return attachment.link.resource === resource;
    }

    isCurrent(attachment: AttachmentEntity<any>): boolean {
        return (this.playlist.has(attachment))
            && (this.playlist.getCurrent() === attachment);
    }
}