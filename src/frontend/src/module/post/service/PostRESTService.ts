import {Injectable} from "@angular/core";
import {Http, Headers} from "@angular/http"

import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthToken} from "../../auth/service/AuthToken";
import {CreatePostRequest, CreatePostResponse200} from "../definitions/paths/create";
import {Observable} from "rxjs/Observable";

@Injectable()
export class PostRESTService extends AbstractRESTService
{
    constructor(protected http: Http,
                protected token: AuthToken,
                protected messages: MessageBusService
    ) { super(http, token, messages); }

    getPost(postId: number) {
        return this.handle(this.http.get(`/backend/api/post/${postId}/get`));
    }

    createPost(request: CreatePostRequest): Observable<CreatePostResponse200> {
        let authHeader = new Headers();

        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        let url = `/backend/api/protected/post/create`;
        let headers = { headers: authHeader };

        return this.handle(this.http.put(url, JSON.stringify(request), headers));
    }

    editPost(postId: number, collectionId: number, content: string) {
        let authHeader = new Headers();

        if (this.token.hasToken()) {
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.post(`/backend/api/protected/post/${postId}/delete`, JSON.stringify({
            collection_id: collectionId,
            content: content
        }), { headers: authHeader }));
    }

    deletePost(postId: number) {
        let authHeader = new Headers();

        if (this.token.hasToken()) {
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.delete(`/backend/api/protected/post/${postId}/delete`, {headers: authHeader}));
    }
}
