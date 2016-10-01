import {Injectable} from "@angular/core";

import {Playlist} from "./playlist";
import {AttachmentEntity} from "../../../attachment/definitions/entity/AttachmentEntity";
import {Controls} from "./controls";

@Injectable()
export class ContentPlayerService
{
    static LOCAL_STORAGE_KEY = 'cass.module.player.service';

    private enabled: boolean = false;
    private visible: boolean = false;

    public controls: Controls = new Controls(this);
    public playlist: Playlist = new Playlist();

    constructor() {
        if(window.localStorage.hasOwnProperty(ContentPlayerService.LOCAL_STORAGE_KEY)) {
            this.enabled = window.localStorage[ContentPlayerService.LOCAL_STORAGE_KEY] === "true";
        }
    }

    open(attachment: AttachmentEntity<any>) {
        if(! this.playlist.has(attachment)) {
            this.playlist.push(attachment);
        }

        this.playlist.setAsCurrent(attachment);

        this.enable();
        this.show();
    }

    isSupported(attachment: AttachmentEntity<any>): boolean {
        return !!~[
            "webm",
            "youtube",
        ].indexOf(attachment.link.resource);
    }

    enable() {
        this.enabled = true;
    }

    disabled() {
        this.enabled = false;
    }

    show() {
        this.visible = true;
    }

    hide() {
        this.visible = false;
    }

    toggle() {
        if(this.shouldBeVisible()) {
            this.visible = false;
        }else{
            this.enabled = !this.enabled;
        }

        window.localStorage[ContentPlayerService.LOCAL_STORAGE_KEY] = this.enabled;
    }

    isEnabled(): boolean {
        return this.enabled;
    }

    shouldBeVisible(): boolean {
        return this.visible;
    }
}
