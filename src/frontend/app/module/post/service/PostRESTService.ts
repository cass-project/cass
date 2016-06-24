import {Injectable} from "angular2/core";
import {Http} from "angular2/http"
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {Account} from "../../account/definitions/entity/Account";
import {MessageBusService} from "../../message/service/MessageBusService/index";

@Injectable()
export class PostRESTService extends AbstractRESTService {
    constructor(protected  http:Http, protected messages:MessageBusService) {
        super(http, messages);
    }

    getPost(postId: number)
    {
        return this.handle(this.http.get(`/backend/api/post/${postId}/get`));
    }

    createPost(profile_id: number, collectionId: number, content: string, attachments, links)
    {
        return this.handle(this.http.put(`/backend/api/protected/post/create`, JSON.stringify({
            profile_id: profile_id,
            collection_id: collectionId,
            content: content,
            attachments: attachments,
            links: links
        })));
    }

    editPost(postId: number, collectionId: number, content: string, attachments, links)
    {
        return this.handle(this.http.post(`/backend/api/protected/post/${postId}/delete`, JSON.stringify({
            collection_id: collectionId,
            content: content,
            attachments: attachments,
            links: links
        })));
    }

    deletePost(postId: number)
    {
        return this.handle(this.http.delete(`/backend/api/protected/post/${postId}/delete`));
    }
}
