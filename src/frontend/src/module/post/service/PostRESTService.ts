import {Injectable} from "angular2/core";
import {Http, Headers} from "angular2/http"
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthToken} from "../../auth/service/AuthToken";

@Injectable()
export class PostRESTService extends AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) { super(http, token, messages); }

    getPost(postId: number)
    {
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.get(`/backend/api/post/${postId}/get`, {headers: authHeader}));
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
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.post(`/backend/api/protected/post/${postId}/delete`, JSON.stringify({
            collection_id: collectionId,
            content: content,
            attachments: attachments,
            links: links
        }), {headers: authHeader}));
    }

    deletePost(postId: number)
    {
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.delete(`/backend/api/protected/post/${postId}/delete`, {headers: authHeader}));
    }
}
