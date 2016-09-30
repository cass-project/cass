import {Injectable} from "@angular/core";
import {PostEntity} from "../../../definitions/entity/Post";

@Injectable()
export class PostPlayerService
{
    private post: PostEntity;
    private opened: boolean;

    public openPost(post: PostEntity) {
        this.post = post;
        this.opened = true;
    }

    public getPost(): PostEntity {
        return this.post;
    }

    public isOpened(): boolean {
        return this.opened;
    }

    public close() {
        this.opened = false;
    }
}