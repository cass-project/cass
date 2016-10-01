import {Injectable} from "@angular/core";
import {PostEntity} from "../../post/definitions/entity/Post";
import {AttachmentEntity} from "../../attachment/definitions/entity/AttachmentEntity";

@Injectable()
export class ContentPlayerService
{
    static LOCAL_STORAGE_KEY = 'cass.module.player.service';

    private enabled: boolean = false;
    private visible: boolean = false;

    constructor() {
        if(window.localStorage.hasOwnProperty(ContentPlayerService.LOCAL_STORAGE_KEY)) {
            this.enabled = !! window.localStorage[ContentPlayerService.LOCAL_STORAGE_KEY];
        }
    }

    toggle() {
        this.enabled = !this.enabled;

        window.localStorage[ContentPlayerService.LOCAL_STORAGE_KEY] = this.enabled;
    }

    isEnabled(): boolean {
        return this.enabled;
    }

    shouldBeVisible(): boolean {
        return this.visible;
    }

    isSupported(playItem: PlayItem): boolean {
        return false;
    }
}

export interface PlayItem
{
    post: PostEntity;
    attachment: AttachmentEntity<any>;
}